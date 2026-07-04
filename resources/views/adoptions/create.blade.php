@extends('layouts.app')

@section('content')
<style>
    .adoption-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .carte-adoption {
        border: 1px solid #dfe8e1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(27, 40, 31, .06);
        height: 100%;
    }

    .apercu-animal {
        width: 100%;
        height: 240px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #e6ece8;
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

    .grille-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .55rem;
        margin-top: .85rem;
    }

    .element-meta {
        border: 1px solid #e7eeea;
        border-radius: 10px;
        padding: .45rem .6rem;
        background: #fbfdfb;
    }

    .element-meta small {
        color: #607065;
        display: block;
        margin-bottom: .08rem;
    }

    .boite-conseils {
        border: 1px dashed #d5e1d8;
        border-radius: 10px;
        padding: .7rem .8rem;
        background: #f9fcfa;
        margin-top: .85rem;
    }

    .boite-conseils ul {
        margin: .35rem 0 0;
        padding-left: 1.1rem;
        color: #47584d;
        font-size: .9rem;
    }

    .carte-adoption .form-control,
    .carte-adoption .btn {
        border-radius: 10px;
    }

    @media (max-width: 767px) {
        .grille-meta { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .apercu-animal { height: 210px; }
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

<div class="adoption-coquille">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <a href="{{ route('animals.show', $animal) }}" class="btn btn-outline-secondary btn-sm">Retour aux details</a>
        <span class="badge-statut statut-{{ $animal->statut }}">{{ str_replace('_', ' ', $animal->statut) }}</span>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <aside class="carte-adoption p-3 p-lg-4">
                <img src="{{ $urlImage }}" alt="Photo de {{ $animal->nom }}" class="apercu-animal mb-3">

                <h3 class="mb-1">{{ $animal->nom }}</h3>
                <div class="text-muted">Profil de l'animal a adopter</div>

                <div class="grille-meta">
                    <div class="element-meta">
                        <small>Espece</small>
                        <strong>{{ $animal->espece }}</strong>
                    </div>
                    <div class="element-meta">
                        <small>Race</small>
                        <strong>{{ $animal->race ?? 'Non precisee' }}</strong>
                    </div>
                    <div class="element-meta">
                        <small>Age</small>
                        <strong>{{ $animal->age ?? '?' }} ans</strong>
                    </div>
                    <div class="element-meta">
                        <small>Localisation</small>
                        <strong>{{ $animal->localisation ?? 'Non precisee' }}</strong>
                    </div>
                    <div class="element-meta">
                        <small>Prix d'adoption</small>
                        <strong>{{ number_format((float) $prixAdoption, 2, ',', ' ') }} $</strong>
                    </div>
                </div>

                <div class="boite-conseils">
                    <strong>Conseils pour une bonne demande</strong>
                    <ul>
                        <li>Presentez votre environnement de vie.</li>
                        <li>Indiquez votre experience avec les animaux.</li>
                        <li>Precisez vos disponibilites pour le suivi.</li>
                    </ul>
                </div>
            </aside>
        </div>

        <div class="col-lg-7">
            <section class="carte-adoption p-3 p-lg-4">
                <h2 class="mb-1">Soumettre une demande d'adoption</h2>
                <p class="text-muted small mb-3">Votre message sera envoye a l'equipe du refuge pour evaluation.</p>
                <div class="alert alert-light border small mb-3">
                    Montant fixe a payer pour {{ $animal->nom }} : <strong>{{ number_format((float) $prixAdoption, 2, ',', ' ') }} $</strong>
                </div>

                @if($dejaAdopte)
                    <div class="alert alert-success">
                        Vous avez deja adopte cet animal. Votre demande a ete approuvee et votre paiement est confirme.
                    </div>
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-success">Voir mes paiements</a>
                @elseif($demandeDejaExistante)
                    <div class="alert alert-info">
                        Vous avez deja une demande pour cet animal (statut: {{ $demandeUtilisateur?->statut ?? 'en_attente' }}).
                        @if($paiementReussi)
                            Paiement deja effectue, finalisation en cours.
                        @endif
                    </div>
                    <a href="{{ route('animals.show', $animal) }}" class="btn btn-outline-primary">Retour au detail</a>
                @elseif($animal->statut !== 'disponible')
                    <div class="alert alert-warning">Cet animal n'est pas disponible actuellement pour une nouvelle demande.</div>
                    <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">Voir d'autres animaux</a>
                @else
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Veuillez corriger les erreurs:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('adoptions.store', $animal) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Message au refuge</label>
                            <textarea name="message" class="form-control" rows="8" required placeholder="Expliquez pourquoi vous souhaitez adopter {{ $animal->nom }} et comment vous allez vous en occuper.">{{ old('message') }}</textarea>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-success">Envoyer la demande</button>
                            <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">Voir d'autres animaux</a>
                        </div>
                    </form>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
