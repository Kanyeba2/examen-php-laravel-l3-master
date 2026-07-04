@extends('layouts.app')

@section('content')
<style>
    .auth-connexion-page {
        max-width: 980px;
        margin: 0 auto;
    }

    .auth-connexion-cadre {
        border: 1px solid #dde8e0;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 28px rgba(25, 39, 29, .08);
    }

    .auth-connexion-info {
        height: 100%;
        padding: 1.2rem;
        color: #f4fbf4;
        background:
            radial-gradient(circle at 14% 20%, rgba(255, 255, 255, .16) 0, rgba(255, 255, 255, 0) 42%),
            linear-gradient(150deg, #1d2f26 0%, #2a4a37 100%);
    }

    .auth-connexion-info h3 {
        margin-bottom: .45rem;
        font-weight: 700;
    }

    .auth-connexion-info p {
        color: #d7e6da;
        margin-bottom: 1rem;
    }

    .auth-connexion-liste {
        margin: 0;
        padding-left: 1rem;
        color: #e1eee4;
    }

    .auth-connexion-liste li {
        margin-bottom: .45rem;
    }

    .auth-connexion-formulaire {
        padding: 1.2rem;
    }

    .auth-connexion-titre {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #16241c;
    }

    .auth-connexion-sous-titre {
        margin: .2rem 0 1.1rem;
        color: #5c6c62;
    }

    .auth-connexion-formulaire .form-control,
    .auth-connexion-formulaire .btn {
        border-radius: 10px;
    }

    .auth-connexion-formulaire .form-control {
        border-color: #d8e2db;
        min-height: 44px;
    }

    .auth-connexion-formulaire .form-control:focus {
        border-color: #84a791;
        box-shadow: 0 0 0 .2rem rgba(47, 125, 63, .12);
    }

    .auth-connexion-bas {
        margin-top: .9rem;
        font-size: .92rem;
    }

    .auth-connexion-bas a {
        text-decoration: none;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .auth-connexion-info {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }
    }

    @media (max-width: 767px) {
        .auth-connexion-titre {
            font-size: 1.75rem;
        }
    }
</style>

<div class="auth-connexion-page">
    <div class="auth-connexion-cadre">
        <div class="row g-0">
            <div class="col-lg-5">
                <aside class="auth-connexion-info">
                    <h3>Bienvenue</h3>
                    <p>Connectez-vous pour suivre vos demandes, vos paiements et vos notifications en temps reel.</p>
                    <ul class="auth-connexion-liste">
                        <li>Suivi complet des adoptions</li>
                        <li>Historique des transactions mobile</li>
                        <li>Notifications en direct</li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-7">
                <section class="auth-connexion-formulaire">
                    <h2 class="auth-connexion-titre">Connexion</h2>
                    <p class="auth-connexion-sous-titre">Accedez a votre espace en toute securite.</p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Verification requise:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" value="1" class="form-check-input" id="seSouvenirMoi" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="seSouvenirMoi">Se souvenir de moi</label>
                        </div>
                        <button class="btn btn-primary px-4">Se connecter</button>
                    </form>

                    <div class="auth-connexion-bas">
                        Pas encore de compte ? <a href="{{ route('register') }}">Creer un compte</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
