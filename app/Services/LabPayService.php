<?php

namespace App\Services;

use App\Models\MobilePayment;
use Illuminate\Support\Facades\Http;
use Throwable;

class LabPayService
{
    // Encapsule les appels HTTP vers l'API LabPay.
    public function initiate(MobilePayment $payment): array
    {
        if (! $this->isEnabled()) {
            return [
                'status' => 'pending',
                'provider_reference' => 'SIM-'.strtoupper(substr(md5((string) $payment->id), 0, 10)),
                'payload' => [
                    'mode' => 'simulation',
                    'message' => 'Paiement initialise en mode simulation.',
                ],
            ];
        }

        try {
            $response = Http::acceptJson()
                ->withToken((string) config('services.labpay.token'))
                ->timeout(20)
                ->post(rtrim((string) config('services.labpay.base_url'), '/').'/payments/initiate', [
                    'provider' => $payment->fournisseur,
                    'amount' => (float) $payment->montant,
                    'currency' => $payment->devise,
                    'phone' => $payment->numero_telephone,
                    'merchant_reference' => $payment->reference_interne,
                ]);

            $payload = $response->json();

            if ($response->failed()) {
                return [
                    'status' => 'failed',
                    'payload' => $payload,
                ];
            }

            return [
                'status' => (string) ($payload['status'] ?? 'pending'),
                'provider_reference' => $payload['provider_reference'] ?? $payload['transaction_id'] ?? null,
                'payload' => $payload,
            ];
        } catch (Throwable $exception) {
            return [
                'status' => 'failed',
                'payload' => [
                    'error' => $exception->getMessage(),
                ],
            ];
        }
    }

    public function confirm(MobilePayment $payment): array
    {
        if (! $this->isEnabled()) {
            return [
                'status' => 'success',
                'provider_reference' => $payment->reference_fournisseur,
                'payload' => [
                    'mode' => 'simulation',
                    'message' => 'Paiement confirme en mode simulation.',
                ],
            ];
        }

        try {
            $response = Http::acceptJson()
                ->withToken((string) config('services.labpay.token'))
                ->timeout(20)
                ->post(rtrim((string) config('services.labpay.base_url'), '/').'/payments/confirm', [
                    'merchant_reference' => $payment->reference_interne,
                    'provider_reference' => $payment->reference_fournisseur,
                ]);

            $payload = $response->json();

            if ($response->failed()) {
                return [
                    'status' => 'failed',
                    'payload' => $payload,
                ];
            }

            return [
                'status' => (string) ($payload['status'] ?? 'pending'),
                'provider_reference' => $payload['provider_reference'] ?? $payment->reference_fournisseur,
                'payload' => $payload,
            ];
        } catch (Throwable $exception) {
            return [
                'status' => 'failed',
                'payload' => [
                    'error' => $exception->getMessage(),
                ],
            ];
        }
    }

    private function isEnabled(): bool
    {
        return (bool) config('services.labpay.enabled', false)
            && filled(config('services.labpay.base_url'))
            && filled(config('services.labpay.token'));
    }
}
