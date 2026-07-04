<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\CodeOtpConnexion;
use App\Mail\EmailBienvenue;
use App\Mail\EmailConfirmationAdresse;
use App\Models\ActivityLog;
use App\Models\CodeVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Gere authentification, profil utilisateur et logique OTP/2FA.
    public function showLogin(): View
    {
        return view('auth.login');
    }
//le code qui fait la connexion de l'utilisateur et la verification de son compte (actif ou inactif) et la verification du 2FA

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('mot_de_passe'), $user->mot_de_passe)) {
            ActivityLog::trace(
                null,
                'echec_connexion',
                'user',
                $user?->id,
                'Tentative de connexion avec identifiants invalides.',
                'warning',
                ['email' => $request->validated('email')],
            );

            return back()->withErrors(['email' => 'Identifiants incorrects.']);
        }

        if (! $user->actif) {
            ActivityLog::trace(
                $user->id,
                'connexion_compte_inactif',
                'user',
                $user->id,
                'Tentative de connexion avec un compte inactif.',
                'warning',
            );

            return back()->withErrors(['email' => 'Votre compte est desactive.']);
        }
// le code qui fait la verification du 2FA pour l'utilisateur et l'envoie d'un email avec un code OTP
        if ($user->two_factor_enabled) {
            $request->session()->put('2fa:user_id', $user->id);
            $request->session()->put('2fa:remember', $request->boolean('remember'));

            $code = $this->createOtpCodeFor($user);
            Mail::to($user->email)->send(new CodeOtpConnexion($user, $code));

            $message = 'Un code OTP a ete envoye a votre adresse email.';
            if (app()->isLocal()) {
                $message .= ' Code de test local: '.$code;
            }
//
            ActivityLog::trace(
                $user->id,
                'otp_envoye_connexion',
                'user',
                $user->id,
                'Code OTP envoye pour verification 2FA.',
            );

            return redirect()->route('two-factor.verify.form')->with('success', $message);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        ActivityLog::trace(
            $user->id,
            'connexion_reussie',
            'user',
            $user->id,
            'Connexion reussie.',
        );

        return redirect($this->redirectToRole($user->role));
    }
//le code qui fait l'affichage de la page d'inscription de l'utilisateur
    public function showRegister(): View
    {
        return view('auth.register');
    }
//le code qui fait l'inscription d'un utilisateur et l'envoie d'un email de bienvenue et un email de confirmation d'adresse
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
        $data['role'] = 'client';
        $data['actif'] = true;

        $user = User::create($data);

        $verificationCode = (string) random_int(100000, 999999);
        CodeVerification::create([
            'user_id' => $user->id,
            'code' => $verificationCode,
            'expires_at' => now()->addMinutes(10),
            'utilise' => false,
        ]);
//cette partie permett de faire 
        Mail::to($user->email)->queue(new EmailBienvenue($user));
        Mail::to($user->email)->queue(new EmailConfirmationAdresse($user, $verificationCode));

        Auth::login($user);

        ActivityLog::trace(
            $user->id,
            'inscription_utilisateur',
            'user',
            $user->id,
            'Inscription d\'un nouvel utilisateur client.',
        );

        return redirect()->route('dashboard');
    }
//le code qui fait la deconnexion de l'utilisateur et la suppression de la session

    public function logout(Request $request): RedirectResponse
    {
        $currentUser = $request->user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        ActivityLog::trace(
            $currentUser?->id,
            'deconnexion',
            'user',
            $currentUser?->id,
            'Deconnexion utilisateur.',
        );

        return redirect()->route('login');
    }

    public function showTwoFactorForm(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('2fa:user_id')) {
            return redirect()->route('login')->withErrors(['email' => 'Session 2FA introuvable. Veuillez vous reconnecter.']);
        }

        return view('auth.two-factor-verify');
    }
//le code qui fait la verification du code OTP pour l'utilisateur
// et la redirection vers la page de l'utilisateur selon son role (admin, manager, client)
    public function verifyTwoFactorCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Veuillez saisir le code OTP.',
            'code.size' => 'Le code OTP doit contenir 6 caracteres.',
        ]);

        $userId = $request->session()->get('2fa:user_id');
        $remember = (bool) $request->session()->get('2fa:remember', false);

        if (! $userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session 2FA expiree. Veuillez vous reconnecter.']);
        }

        $user = User::find($userId);
        if (! $user) {
            $request->session()->forget(['2fa:user_id', '2fa:remember']);

            return redirect()->route('login')->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        $verification = CodeVerification::where('user_id', $user->id)
            ->where('code', $validated['code'])
            ->where('utilise', false)
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();

        if (! $verification) {
            ActivityLog::trace(
                $user->id,
                'echec_verification_otp',
                'user',
                $user->id,
                'Echec de verification OTP.',
                'warning',
            );

            return back()->withErrors(['code' => 'Code OTP invalide ou expire.']);
        }

        $verification->update(['utilise' => true]);

        Auth::login($user, $remember);
        $request->session()->forget(['2fa:user_id', '2fa:remember']);
        $request->session()->regenerate();

        ActivityLog::trace(
            $user->id,
            'verification_otp_reussie',
            'user',
            $user->id,
            'Verification OTP reussie.',
        );

        return redirect($this->redirectToRole($user->role));
    }
// le code qui renvoie un nouveau code OTP à l'utilisateur si la session 2FA est toujours active
    public function resendTwoFactorCode(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('2fa:user_id');
        if (! $userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session 2FA expiree. Veuillez vous reconnecter.']);
        }
// le code qui verifie si l'utilisateur existe et si oui, il genere un nouveau code OTP et l'envoie par email
        $user = User::find($userId);
        if (! $user) {
            $request->session()->forget(['2fa:user_id', '2fa:remember']);

            return redirect()->route('login')->withErrors(['email' => 'Utilisateur introuvable.']);
        }
// le code qui genere un nouveau code OTP et l'envoie par email
        $code = $this->createOtpCodeFor($user);
        Mail::to($user->email)->send(new CodeOtpConnexion($user, $code));

        $message = 'Un nouveau code OTP a ete envoye.';
        if (app()->isLocal()) {
            $message .= ' Code de test local: '.$code;
        }

        return back()->with('success', $message);
    }
// le code qui fait l'affichage du profil de l'utilisateur
    public function showProfile(): View
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }
//le code qui fait la mise à jour du profil de l'utilisateur (nom, telephone, adresse, photo de profil)
// et la possibilité de supprimer la photo de profil
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'photo_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'supprimer_photo_profil' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();

        $payload = [
            'nom' => $validated['nom'],
            'telephone' => $validated['telephone'] ?? null,
            'adresse' => $validated['adresse'] ?? null,
        ];

        if (($validated['supprimer_photo_profil'] ?? false) && $user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $payload['profile_photo_path'] = null;
        }

        if ($request->hasFile('photo_profil')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $payload['profile_photo_path'] = $request->file('photo_profil')->store('profiles', 'public');
        }

        $user->update($payload);

        return back()->with('success', 'Profil mis a jour avec succes.');
    }
//le code qui fait la mise à jour du parametre 2FA pour l'utilisateur (activer ou désactiver 2FA)
    public function updateTwoFactorSetting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $enabled = (bool) ($validated['two_factor_enabled'] ?? false);

        $request->user()->update([
            'two_factor_enabled' => $enabled,
        ]);

        return back()->with('success', 'Parametre 2FA mis a jour avec succes.');
    }
//le code qui génèrer le code de OTP
    private function createOtpCodeFor(User $user): string
    {
        CodeVerification::where('user_id', $user->id)
            ->where('utilise', false)
            ->update(['utilise' => true]);

        $code = (string) random_int(100000, 999999);

        CodeVerification::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'utilise' => false,
        ]);

        return $code;
    }
// le code qui fait la rediction de chacun à sa partie (un client puisse voir sa page et un admin puisse voir sa page)
// et le gestionnaire puisse voir aussi sa page 
    private function redirectToRole(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'manager' => route('manager.dashboard'),
            default => route('dashboard'),
        };
    }
}
