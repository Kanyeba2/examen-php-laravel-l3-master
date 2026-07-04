@extends('layouts.app')

@section('content')
<style>
    .page-formulaire {
        background: #f7f9fc;
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 0.95rem;
    }

    .bloc-form {
        border: 1px solid #e1e9f5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(18, 33, 56, 0.04);
        overflow: hidden;
    }

    .bloc-entete {
        padding: 0.8rem 0.9rem;
        border-bottom: 1px solid #edf2f8;
    }

    .bloc-entete h2,
    .entete-page h2 {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .bloc-corps {
        padding: 0.95rem;
    }

    .form-label {
        font-weight: 700;
        color: #344867;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border-color: #d7e1ef;
    }

    .zone-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .fiche-utilisateur {
        background: #fbfcff;
        border: 1px solid #e5eefb;
        border-radius: 14px;
        padding: 0.85rem;
    }

    .avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, #2f5ad9, #2143a2);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
</style>

<div class="page-formulaire">
    <div class="entete-page mb-3">
        <h2>Modifier l'utilisateur</h2>
        <p class="text-muted mb-0">Mettre à jour les informations du compte, le rôle et l'état de l'utilisateur.</p>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="bloc-form">
                <div class="bloc-entete">
                    <h2>Fiche utilisateur</h2>
                </div>
                <div class="bloc-corps">
                    <form method="POST" action="{{ route('admin.users.update', ['user' => request()->route('user')]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="nom">Nom</label>
                                <input id="nom" type="text" name="nom" class="form-control" value="{{ old('nom', $utilisateur->nom) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $utilisateur->email) }}">
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label" for="telephone">Téléphone</label>
                                <input id="telephone" type="text" name="telephone" class="form-control" value="{{ old('telephone', $utilisateur->telephone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="adresse">Adresse</label>
                                <input id="adresse" type="text" name="adresse" class="form-control" value="{{ old('adresse', $utilisateur->adresse) }}">
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <label class="form-label" for="role">Rôle</label>
                                <select id="role" name="role" class="form-select">
                                    <option value="client" @selected(old('role', $utilisateur->role) === 'client')>Client</option>
                                    <option value="manager" @selected(old('role', $utilisateur->role) === 'manager')>Gestionnaire</option>
                                    <option value="admin" @selected(old('role', $utilisateur->role) === 'admin')>Administrateur</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="actif" name="actif" @checked(old('actif', $utilisateur->actif))>
                                    <label class="form-check-label" for="actif">Compte actif</label>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="two_factor_enabled" name="two_factor_enabled" @checked(old('two_factor_enabled', $utilisateur->two_factor_enabled))>
                                    <label class="form-check-label" for="two_factor_enabled">2FA activée</label>
                                </div>
                            </div>
                        </div>

                        <div class="zone-actions">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @php
                $photoPath = $utilisateur->profile_photo_path;
                $photo = $photoPath ? \Illuminate\Support\Facades\Storage::url($photoPath) : null;
                $initiale = mb_strtoupper(mb_substr(trim((string) $utilisateur->nom), 0, 1));
            @endphp
            <div class="fiche-utilisateur">
                <div class="d-flex gap-3 align-items-center">
                    <span class="avatar">@if($photo)<img src="{{ $photo }}" alt="Photo de {{ $utilisateur->nom }}">@else{{ $initiale }}@endif</span>
                    <div>
                        <h3 class="h6 fw-bold mb-1">{{ $utilisateur->nom }}</h3>
                        <div class="text-muted small">{{ $utilisateur->email }}</div>
                        <div class="text-muted small">{{ ucfirst((string) $utilisateur->role) }}</div>
                    </div>
                </div>
                <hr>
                <p class="small text-muted mb-0">Cette fiche permet de gérer les informations de compte dans un format compatible avec un environnement d'entreprise.</p>
            </div>
        </div>
    </div>
</div>
@endsection
