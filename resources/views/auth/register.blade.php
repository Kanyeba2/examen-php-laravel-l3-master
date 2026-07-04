@extends('layouts.app')

@section('content')
<style>
    .inscription-page {
        max-width: 980px;
        margin: 0 auto;
    }

    .inscription-cadre {
        border: 1px solid #dde8e0;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 28px rgba(25, 39, 29, .08);
    }

    .inscription-info {
        height: 100%;
        padding: 1.2rem;
        color: #f3fbf5;
        background:
            radial-gradient(circle at 12% 16%, rgba(255, 255, 255, .16) 0, rgba(255, 255, 255, 0) 42%),
            linear-gradient(145deg, #233928 0%, #376146 100%);
    }

    .inscription-info h3 {
        margin-bottom: .45rem;
        font-weight: 700;
    }

    .inscription-info p {
        color: #d5e6da;
        margin-bottom: 1rem;
    }

    .inscription-liste {
        margin: 0;
        padding-left: 1rem;
        color: #e2efe6;
    }

    .inscription-liste li {
        margin-bottom: .45rem;
    }

    .inscription-formulaire {
        padding: 1.2rem;
    }

    .inscription-titre {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #16241c;
    }

    .inscription-sous-titre {
        margin: .2rem 0 1.1rem;
        color: #5c6c62;
    }

    .inscription-formulaire .form-control,
    .inscription-formulaire .btn {
        border-radius: 10px;
    }

    .inscription-formulaire .form-control {
        border-color: #d8e2db;
        min-height: 44px;
    }

    .inscription-formulaire .form-control:focus {
        border-color: #84a791;
        box-shadow: 0 0 0 .2rem rgba(47, 125, 63, .12);
    }

    .inscription-grille {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .inscription-grille .champ-large {
        grid-column: span 2;
    }

    .inscription-bas {
        margin-top: .9rem;
        font-size: .92rem;
    }

    .inscription-bas a {
        text-decoration: none;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .inscription-info {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }
    }

    @media (max-width: 767px) {
        .inscription-titre {
            font-size: 1.75rem;
        }

        .inscription-grille {
            grid-template-columns: 1fr;
        }

        .inscription-grille .champ-large {
            grid-column: auto;
        }
    }
</style>

<div class="inscription-page">
    <div class="inscription-cadre">
        <div class="row g-0">
            <div class="col-lg-5">
                <aside class="inscription-info">
                    <h3>Demarrage rapide</h3>
                    <p>Creez votre compte pour demarrer vos demandes d'adoption dans un espace securise.</p>
                    <ul class="inscription-liste">
                        <li>Suivi simple de vos demandes</li>
                        <li>Paiements et recus centralises</li>
                        <li>Notifications automatiques</li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-7">
                <section class="inscription-formulaire">
                    <h2 class="inscription-titre">Creer un compte</h2>
                    <p class="inscription-sous-titre">Rejoignez la plateforme pour adopter en toute confiance.</p>

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

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="inscription-grille">
                            <div class="champ-large">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                            </div>
                            <div class="champ-large">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div>
                                <label class="form-label">Telephone</label>
                                <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                            </div>
                            <div>
                                <label class="form-label">Adresse</label>
                                <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}">
                            </div>
                            <div>
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" required>
                            </div>
                            <div>
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="mot_de_passe_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary px-4">S'inscrire</button>
                        </div>
                    </form>

                    <div class="inscription-bas">
                        Vous avez deja un compte ? <a href="{{ route('login') }}">Se connecter</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
