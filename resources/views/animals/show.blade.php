@extends('layouts.app')

@section('content')
<style>
    .animal-detail-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .carte-principale-animal,
    .carte-laterale-animal {
        border: 1px solid #dfe8e1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(27, 40, 31, .06);
    }

    .couverture-animal {
        width: 100%;
        height: 360px;
        object-fit: cover;
        border-radius: 12px;
    }

    .badge-statut {
        border-radius: 999px;
        padding: .25rem .65rem;
        font-size: .78rem;
        font-weight: 700;
        text-transform: capitalize;
    }

    .statut-disponible { background: #def4e2; color: #1f7a36; }
    .statut-en_attente { background: #fff2d8; color: #946200; }
    .statut-adopte { background: #e4e9f4; color: #41557a; }

    .grille-infos {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .65rem;
    }

    .element-info {
        border: 1px solid #e7eeea;
        border-radius: 10px;
        padding: .55rem .7rem;
        background: #fbfdfb;
    }

    .element-info small {
        display: block;
        color: #607065;
        margin-bottom: .08rem;
    }

    .description-animal {
        border: 1px solid #e7eeea;
        border-radius: 10px;
        padding: .8rem;
        background: #fcfefd;
        color: #2f3f35;
        margin-top: .7rem;
    }

    .apercu-lateral {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e4ebe6;
        margin-bottom: .8rem;
    }

    @media (max-width: 991px) {
        .couverture-animal { height: 260px; }
    }

    @media (max-width: 767px) {
        .grille-infos { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    }
</style>

@php
    $imageChienSecours = 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?q=80&w=1280&auto=format&fit=crop';
    $imageChatSecours = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=1280&auto=format&fit=crop';
    $imageGeneriqueSecours = 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1280&auto=format&fit=crop';

    $especeMinuscule = strtolower((string) $animal->espece);
    $imageSecours = str_contains($especeMinuscule, 'chat')
        ? $imageChatSecours
        : (str_contains($especeMinuscule, 'chien') ? $imageChienSecours : $imageGeneriqueSecours);

    $urlImage = $animal->chemin_image
        ? \Illuminate\Support\Facades\Storage::url($animal->chemin_image)
        : $imageSecours;

    $demandeUtilisateur = $etatDemande['demande'] ?? null;
    $paiementReussi = (bool) ($etatDemande['paiement_reussi'] ?? false);
    $dejaAdopte = (bool) ($etatDemande['deja_adopte'] ?? false);
    $demandeDejaExistante = (bool) ($etatDemande['demande_deja_existante'] ?? false);
@endphp

<div class="animal-detail-coquille">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary btn-sm">Retour aux animaux</a>
        <span class="badge-statut statut-{{ $animal->statut }}">{{ str_replace('_', ' ', $animal->statut) }}</span>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <article class="carte-principale-animal p-3 p-lg-4">
                <img src="{{ $urlImage }}" alt="Photo de {{ $animal->nom }}" class="couverture-animal mb-3">

                <h2 class="mb-1">{{ $animal->nom }}</h2>
                <div class="text-muted mb-3">Profil complet de l'animal</div>

                <div class="grille-infos">
                    <div class="element-info">
                        <small>Espece</small>
                        <strong>{{ $animal->espece }}</strong>
                    </div>
                    <div class="element-info">
                        <small>Race</small>
                        <strong>{{ $animal->race ?? 'Non precisee' }}</strong>
                    </div>
                    <div class="element-info">
                        <small>Age</small>
                        <strong>{{ $animal->age ?? '?' }} ans</strong>
                    </div>
                    <div class="element-info">
                        <small>Genre</small>
                        <strong>{{ $animal->genre === 'female' ? 'Femelle' : 'Male' }}</strong>
                    </div>
                    <div class="element-info">
                        <small>Taille</small>
                        <strong>{{ $animal->taille ?? 'Non precisee' }}</strong>
                    </div>
                    <div class="element-info">
                        <small>Localisation</small>
                        <strong>{{ $animal->localisation ?? 'Non precisee' }}</strong>
                    </div>
                    <div class="element-info">
                        <small>Prix d'adoption</small>
                        <strong>{{ number_format((float) $prixAdoption, 2, ',', ' ') }} $</strong>
                    </div>
                </div>

                <div class="description-animal">
                    {{ $animal->description ?: 'Aucune description supplementaire n\'a ete fournie pour le moment.' }}
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            <aside class="carte-laterale-animal p-3 p-lg-4">
                <img src="{{ $urlImage }}" alt="Apercu de {{ $animal->nom }}" class="apercu-lateral">
                <h4 class="mb-1">Demande d'adoption</h4>
                <p class="text-muted small mb-3">Statut de votre dossier pour cet animal.</p>

                @auth
                    @if($dejaAdopte)
                        <div class="alert alert-success">
                            Vous avez deja adopte cet animal. Votre demande est approuvee et votre paiement est confirme.
                        </div>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-success w-100">Voir mes paiements</a>
                    @elseif($demandeDejaExistante)
                        <div class="alert alert-info">
                            Vous avez deja une demande pour cet animal (statut: {{ $demandeUtilisateur?->statut ?? 'en_attente' }}).
                            @if($paiementReussi)
                                Paiement deja effectue, en attente de confirmation finale.
                            @endif
                        </div>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-primary w-100">Suivre mon dossier</a>
                    @elseif($animal->statut !== 'disponible')
                        <div class="alert alert-warning">
                            Cet animal n'est pas disponible actuellement pour une nouvelle demande.
                        </div>
                        <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary w-100">Voir d'autres animaux</a>
                    @else
                        <a href="{{ route('adoptions.create', $animal) }}" class="btn btn-success w-100">Faire une demande d'adoption</a>
                    @endif
                @else
                    <p class="mb-2">Connectez-vous pour faire une demande d'adoption.</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Se connecter</a>
                @endauth
            </aside>
        </div>
    </div>
</div>
@endsection
