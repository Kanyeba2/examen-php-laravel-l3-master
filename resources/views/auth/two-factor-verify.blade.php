@extends('layouts.app')

@section('content')
<style>
    .verification-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .verification-cadre {
        border: 1px solid #dde8e0;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 28px rgba(25, 39, 29, .08);
    }

    .verification-info {
        height: 100%;
        padding: 1.2rem;
        color: #f3fbf5;
        background:
            radial-gradient(circle at 14% 20%, rgba(255, 255, 255, .15) 0, rgba(255, 255, 255, 0) 42%),
            linear-gradient(150deg, #1f3327 0%, #2f5742 100%);
    }

    .verification-info h3 {
        margin-bottom: .45rem;
        font-weight: 700;
    }

    .verification-info p {
        color: #d6e8dc;
        margin-bottom: 1rem;
    }

    .verification-liste {
        margin: 0;
        padding-left: 1rem;
        color: #e2efe6;
    }

    .verification-liste li {
        margin-bottom: .45rem;
    }

    .verification-formulaire {
        padding: 1.2rem;
    }

    .verification-titre {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 700;
        color: #16241c;
    }

    .verification-sous-titre {
        margin: .2rem 0 1.1rem;
        color: #5c6c62;
    }

    .verification-formulaire .form-control,
    .verification-formulaire .btn {
        border-radius: 10px;
    }

    .verification-formulaire .form-control {
        border-color: #d8e2db;
        min-height: 44px;
        letter-spacing: .18rem;
        font-weight: 600;
        text-align: center;
    }

    .verification-formulaire .form-control:focus {
        border-color: #84a791;
        box-shadow: 0 0 0 .2rem rgba(47, 125, 63, .12);
    }

    .verification-actions {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
        align-items: center;
    }

    @media (max-width: 991px) {
        .verification-info {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }
    }

    @media (max-width: 767px) {
        .verification-titre {
            font-size: 1.65rem;
        }
    }
</style>

<div class="verification-page">
    <div class="verification-cadre">
        <div class="row g-0">
            <div class="col-lg-5">
                <aside class="verification-info">
                    <h3>Verification de securite</h3>
                    <p>Un code a usage unique a ete envoye sur votre adresse email.</p>
                    <ul class="verification-liste">
                        <li>Saisissez le code a 6 chiffres</li>
                        <li>Le code expire rapidement</li>
                        <li>Vous pouvez en demander un nouveau</li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-7">
                <section class="verification-formulaire">
                    <h2 class="verification-titre">Verification 2FA</h2>
                    <p class="verification-sous-titre">Finalisez votre connexion avec votre code OTP.</p>

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

                    <form method="POST" action="{{ route('two-factor.verify') }}" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Code OTP (6 chiffres)</label>
                            <input type="text" name="code" class="form-control" maxlength="6" value="{{ old('code') }}" required>
                        </div>
                        <div class="verification-actions">
                            <button class="btn btn-primary px-4">Valider le code</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('two-factor.resend') }}" class="verification-actions">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm">Renvoyer le code</button>
                        <a href="{{ route('login') }}" class="btn btn-link btn-sm text-decoration-none">Retour a la connexion</a>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
