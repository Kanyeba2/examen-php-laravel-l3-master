<?php

namespace App\Http\Controllers;

use App\Events\MobilePaymentStatusUpdated;
use App\Http\Requests\ConfirmMobilePaymentRequest;
use App\Http\Requests\InitiateMobilePaymentRequest;
use App\Models\ActivityLog;
use App\Models\AdoptionRequest;
use App\Models\MobilePayment;
use App\Models\ParametreSysteme;
use App\Services\LabPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MobilePaymentController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $tarifParDefaut = (float) ParametreSysteme::obtenirValeur('default_adoption_fee', '100');

        $paymentsQuery = MobilePayment::with('demandeAdoption.animal')
            ->where('utilisateur_id', $user->id)
            ->latest();

        if (request()->filled('statut')) {
            $paymentsQuery->where('statut', request()->string('statut')->value());
        }

        if (request()->filled('fournisseur')) {
            $paymentsQuery->where('fournisseur', request()->string('fournisseur')->value());
        }

        if (request()->filled('date_from')) {
            $paymentsQuery->whereDate('created_at', '>=', request()->date('date_from'));
        }

        if (request()->filled('date_to')) {
            $paymentsQuery->whereDate('created_at', '<=', request()->date('date_to'));
        }

        if (request()->filled('search')) {
            $term = request()->string('search')->trim()->value();
            $paymentsQuery->where(function ($sub) use ($term) {
                $sub->where('reference_interne', 'like', '%'.$term.'%')
                    ->orWhere('reference_fournisseur', 'like', '%'.$term.'%')
                    ->orWhere('numero_telephone', 'like', '%'.$term.'%');
            });
        }

        $payments = $paymentsQuery->paginate(10)->withQueryString();

        $paymentStats = [
            'total' => MobilePayment::where('utilisateur_id', $user->id)->count(),
            'reussi' => MobilePayment::where('utilisateur_id', $user->id)->where('statut', 'reussi')->count(),
            'en_attente' => MobilePayment::where('utilisateur_id', $user->id)->where('statut', 'en_attente')->count(),
            'echoue' => MobilePayment::where('utilisateur_id', $user->id)->where('statut', 'echoue')->count(),
            'montant_total_paye' => (float) MobilePayment::where('utilisateur_id', $user->id)->where('statut', 'reussi')->sum('montant'),
        ];

        $dernierPaiementReussi = MobilePayment::with('demandeAdoption.animal')
            ->where('utilisateur_id', $user->id)
            ->where('statut', 'reussi')
            ->latest()
            ->first();

        $adoptionRequests = AdoptionRequest::with('animal')
            ->where('utilisateur_id', $user->id)
            ->latest()
            ->get()
            ->each(function (AdoptionRequest $demande) use ($tarifParDefaut) {
                $demande->montant_a_payer = (float) ($demande->animal?->prix_adoption ?? $tarifParDefaut);
            });

        return view('payments.index', compact('payments', 'adoptionRequests', 'paymentStats', 'dernierPaiementReussi'));
    }

    public function store(InitiateMobilePaymentRequest $request, LabPayService $labPayService): RedirectResponse
    {
        $payload = $request->validated();
        $tarifParDefaut = (float) ParametreSysteme::obtenirValeur('default_adoption_fee', '100');
        $montantFixe = null;

        if (! empty($payload['demande_adoption_id'])) {
            $demande = AdoptionRequest::with('animal')->where('id', $payload['demande_adoption_id'])
                ->where('utilisateur_id', Auth::id())
                ->first();

            if (! $demande) {
                ActivityLog::trace(
                    Auth::id(),
                    'echec_initiation_paiement',
                    'mobile_payment',
                    null,
                    'Tentative de paiement sur une demande non autorisee.',
                    'warning',
                );

                return back()->withErrors(['payment' => 'Vous ne pouvez pas payer cette demande.']);
            }

            $montantFixe = (float) ($demande->animal?->prix_adoption ?? $tarifParDefaut);
        }

        $payment = MobilePayment::create([
            'utilisateur_id' => Auth::id(),
            'demande_adoption_id' => $payload['demande_adoption_id'] ?? null,
            'fournisseur' => $payload['fournisseur'],
            'montant' => $montantFixe ?? (float) $payload['montant'],
            'devise' => $payload['devise'] ?? 'USD',
            'numero_telephone' => $payload['numero_telephone'],
            'reference_interne' => 'PAY-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6)),
            'statut' => 'en_attente',
        ]);

        $gatewayResult = $labPayService->initiate($payment);
        $oldStatus = $payment->statut;
        $newStatus = $this->normalizeStatus((string) ($gatewayResult['status'] ?? 'pending'));

        $payment->update([
            'reference_fournisseur' => $gatewayResult['provider_reference'] ?? null,
            'payload_initiation' => $gatewayResult['payload'] ?? null,
            'statut' => $newStatus,
        ]);

        if ($oldStatus !== $newStatus) {
            event(new MobilePaymentStatusUpdated($payment->fresh(), $oldStatus, $newStatus));
        }

        $this->synchroniserStatutAnimalSiAdoptionFinalisee($payment);

        ActivityLog::trace(
            Auth::id(),
            'initiation_paiement_mobile',
            'mobile_payment',
            $payment->id,
            sprintf('Paiement %s initie (%s %s).', $payment->reference_interne, $payment->montant, $payment->devise),
        );

        return back()->with('success', 'Paiement initie. Reference: '.$payment->reference_interne);
    }

    public function confirm(ConfirmMobilePaymentRequest $request, MobilePayment $mobilePayment, LabPayService $labPayService): RedirectResponse
    {
        if ((int) $mobilePayment->utilisateur_id !== (int) Auth::id()) {
            ActivityLog::trace(
                Auth::id(),
                'echec_confirmation_paiement',
                'mobile_payment',
                $mobilePayment->id,
                'Tentative de confirmation de paiement non autorisee.',
                'warning',
            );

            abort(403);
        }

        $oldStatus = $mobilePayment->statut;
        $gatewayResult = $labPayService->confirm($mobilePayment);
        $newStatus = $this->normalizeStatus((string) ($gatewayResult['status'] ?? 'pending'));

        $mobilePayment->update([
            'reference_fournisseur' => $gatewayResult['provider_reference'] ?? $mobilePayment->reference_fournisseur,
            'payload_confirmation' => $gatewayResult['payload'] ?? null,
            'statut' => $newStatus,
        ]);

        if ($oldStatus !== $newStatus) {
            event(new MobilePaymentStatusUpdated($mobilePayment->fresh(), $oldStatus, $newStatus));
        }

        $this->synchroniserStatutAnimalSiAdoptionFinalisee($mobilePayment);

        ActivityLog::trace(
            Auth::id(),
            'confirmation_paiement_mobile',
            'mobile_payment',
            $mobilePayment->id,
            sprintf('Paiement %s confirme, statut %s.', $mobilePayment->reference_interne, $newStatus),
            $newStatus === 'echoue' ? 'warning' : 'info',
        );

        return back()->with('success', 'Statut du paiement mis a jour: '.$newStatus.'.');
    }

    public function callback(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference_interne' => ['required', 'string'],
            'statut' => ['required', 'string'],
            'reference_fournisseur' => ['nullable', 'string'],
            'payload' => ['nullable', 'array'],
        ]);

        $payment = MobilePayment::where('reference_interne', $validated['reference_interne'])->firstOrFail();
        $oldStatus = $payment->statut;
        $newStatus = $this->normalizeStatus($validated['statut']);

        $payment->update([
            'statut' => $newStatus,
            'reference_fournisseur' => $validated['reference_fournisseur'] ?? $payment->reference_fournisseur,
            'payload_confirmation' => $validated['payload'] ?? $validated,
        ]);

        if ($oldStatus !== $newStatus) {
            event(new MobilePaymentStatusUpdated($payment->fresh(), $oldStatus, $newStatus));
        }

        $this->synchroniserStatutAnimalSiAdoptionFinalisee($payment);

        ActivityLog::trace(
            $payment->utilisateur_id,
            'callback_paiement_mobile',
            'mobile_payment',
            $payment->id,
            sprintf('Callback recu pour %s, statut %s.', $payment->reference_interne, $newStatus),
            $newStatus === 'echoue' ? 'warning' : 'info',
        );

        return response()->json([
            'code' => 200,
            'message' => 'Callback paiement traite.',
            'data' => [
                'reference_interne' => $payment->reference_interne,
                'statut' => $payment->statut,
            ],
        ]);
    }

    public function pdf(MobilePayment $mobilePayment)
    {
        $utilisateur = Auth::user();

        if (! $utilisateur) {
            abort(403);
        }

        if ($utilisateur->role === 'client' && (int) $mobilePayment->utilisateur_id !== (int) $utilisateur->id) {
            abort(403);
        }

        $mobilePayment->loadMissing(['utilisateur', 'demandeAdoption.animal']);

        $pdf = app('dompdf.wrapper')->loadView('pdf.receipt-mobile-payment', [
            'payment' => $mobilePayment,
        ]);

        ActivityLog::trace(
            Auth::id(),
            'telechargement_recu_paiement_pdf',
            'mobile_payment',
            $mobilePayment->id,
            sprintf('Telechargement du recu PDF du paiement %s.', $mobilePayment->reference_interne),
        );

        return $pdf->download('recu-paiement-'.$mobilePayment->reference_interne.'.pdf');
    }

    private function normalizeStatus(string $status): string
    {
        return match (strtolower($status)) {
            'success', 'succeeded', 'completed', 'reussi' => 'reussi',
            'failed', 'error', 'echoue', 'rejected' => 'echoue',
            default => 'en_attente',
        };
    }

    private function synchroniserStatutAnimalSiAdoptionFinalisee(MobilePayment $payment): void
    {
        if ($payment->statut !== 'reussi' || ! $payment->demande_adoption_id) {
            return;
        }

        $demande = $payment->demandeAdoption()->with('animal')->first();

        if (! $demande || $demande->statut !== 'approuve' || ! $demande->animal) {
            return;
        }

        if ($demande->animal->statut !== 'adopte') {
            $demande->animal->update(['statut' => 'adopte']);
        }
    }
}
