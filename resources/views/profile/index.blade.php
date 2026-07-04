@extends('layouts.app')

@section('content')
<style>
    .profil-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .carte-profil {
        border: 1px solid #dfe8e1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(27, 40, 31, .06);
        height: 100%;
    }

    .avatar-profil {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 3px solid #e2ece3;
        overflow: hidden;
        background: #f0f4f1;
        display: grid;
        place-items: center;
        font-size: 2.2rem;
        color: #3f5647;
        font-weight: 700;
    }

    .avatar-profil img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pastille-meta {
        border: 1px solid #dce7de;
        border-radius: 999px;
        padding: .22rem .6rem;
        font-size: .78rem;
        color: #3f5446;
        background: #f8fbf9;
        font-weight: 600;
    }

    .carte-profil .form-control,
    .carte-profil .form-check-input,
    .carte-profil .btn {
        border-radius: 10px;
    }
</style>

@php
    $avatarUrl = $user->profile_photo_path
        ? \Illuminate\Support\Facades\Storage::url($user->profile_photo_path)
        : null;

    $initial = strtoupper(substr((string) $user->nom, 0, 1));
@endphp

<div class="profil-coquille">
    <div class="row g-3">
        <div class="col-lg-7">
            <section class="carte-profil p-3 p-lg-4">
                <h2 class="mb-3">Mon profil</h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                        <div class="avatar-profil">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="Photo de profil">
                            @else
                                <span>{{ $initial }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="d-flex gap-2 flex-wrap mb-2">
                                <span class="pastille-meta">{{ $user->email }}</span>
                                <span class="pastille-meta text-uppercase">{{ $user->role }}</span>
                            </div>
                            <label class="form-label mb-1">Photo de profil</label>
                            <input type="file" name="photo_profil" class="form-control" accept="image/png,image/jpeg,image/webp">
                            <div class="form-text">PNG/JPG/WEBP, maximum 2 MB.</div>
                            @if($user->profile_photo_path)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="supprimer_photo_profil" name="supprimer_photo_profil">
                                    <label class="form-check-label" for="supprimer_photo_profil">Supprimer la photo actuelle</label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telephone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}" placeholder="Ex: 0812345678">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $user->adresse) }}" placeholder="Votre adresse">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success">Enregistrer mon profil</button>
                    </div>
                </form>
            </section>
        </div>

        <div class="col-lg-5">
            <section class="carte-profil p-3 p-lg-4">
                <h5 class="mb-2">Double authentification (2FA)</h5>
                <p class="text-muted small mb-3">Renforcez la securite de votre compte a chaque connexion.</p>

                <form method="POST" action="{{ route('profile.2fa.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="twoFactorEnabled" name="two_factor_enabled" value="1" {{ $user->two_factor_enabled ? 'checked' : '' }}>
                        <label class="form-check-label" for="twoFactorEnabled">
                            Activer la verification en deux etapes a la connexion
                        </label>
                    </div>

                    <button class="btn btn-outline-primary">Enregistrer le parametre 2FA</button>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
