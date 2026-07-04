@extends('layouts.app')

@section('content')
<style>
    .page-adoptants {
        background: linear-gradient(180deg, #f6f8fc 0%, #eef3fb 100%);
        border: 1px solid #d8e3f3;
        border-radius: 18px;
        padding: 1rem;
    }

    .entete-page {
        margin-bottom: 1rem;
    }

    .entete-page h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .entete-page p {
        margin: 0.35rem 0 0;
        color: #62708f;
    }

    .grille-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .carte-stat {
        border-radius: 14px;
        padding: 0.85rem;
        color: #fff;
        box-shadow: 0 10px 24px rgba(21, 36, 65, 0.12);
    }

    .carte-stat h3 {
        margin: 0 0 0.25rem;
        font-size: 0.92rem;
        font-weight: 700;
        opacity: 0.92;
    }

    .carte-stat .valeur {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
    }

    .carte-stat.clients { background: linear-gradient(135deg, #264a86, #1f3562); }
    .carte-stat.animaux { background: linear-gradient(135deg, #1f7a4d, #15563c); }
    .carte-stat.par-client { background: linear-gradient(135deg, #8a5c12, #6e4a0e); }
    .carte-stat.encaisse { background: linear-gradient(135deg, #4f6fef, #2749b2); }

    .liste-adoptants {
        display: grid;
        gap: 0.9rem;
    }

    .carte-adoptant {
        border: 1px solid #dbe5f4;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(23, 39, 72, 0.06);
        overflow: hidden;
    }

    .carte-adoptant .haut {
        padding: 0.85rem 0.95rem;
        border-bottom: 1px solid #e6edf8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .profil-client {
        display: flex;
        gap: 0.7rem;
        align-items: center;
    }

    .avatar-client,
    .avatar-animal {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #2f5ad9, #2143a2);
        flex-shrink: 0;
    }

    .avatar-client img,
    .avatar-animal img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .infos-client h3,
    .infos-client p,
    .infos-animal h4,
    .infos-animal p {
        margin: 0;
    }

    .infos-client h3 {
        font-size: 1rem;
        font-weight: 800;
        color: #203050;
    }

    .infos-client p {
        font-size: 0.9rem;
        color: #637292;
        margin-top: 0.12rem;
    }

    .badge-compte {
        border-radius: 999px;
        padding: 0.25rem 0.7rem;
        font-size: 0.78rem;
        font-weight: 700;
        background: #edf4ff;
        border: 1px solid #d7e5ff;
        color: #2c56c8;
        white-space: nowrap;
    }

    .corps-adoptant {
        padding: 0.95rem;
    }

    .bloc-animaux {
        margin-top: 0.75rem;
        border: 1px solid #e4ebf7;
        border-radius: 14px;
        background: #fbfcff;
        padding: 0.85rem;
    }

    .bloc-animaux .titre-bloc {
        margin: 0 0 0.75rem;
        font-size: 0.84rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #5a6c8d;
    }

    .grille-animaux {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 0.75rem;
    }

    .carte-animal {
        display: flex;
        gap: 0.7rem;
        border: 1px solid #e1e9f6;
        border-radius: 12px;
        background: #fff;
        padding: 0.7rem;
    }

    .infos-animal h4 {
        font-size: 0.95rem;
        font-weight: 800;
        color: #203050;
    }

    .infos-animal p {
        font-size: 0.87rem;
        color: #5d6f90;
        margin-top: 0.12rem;
    }

    .ligne-paiement {
        display: flex;
        justify-content: space-between;
        gap: 0.65rem;
        align-items: center;
        margin-top: 0.45rem;
        padding-top: 0.45rem;
        border-top: 1px dashed #e0e8f5;
        font-size: 0.82rem;
    }

    .ligne-paiement strong {
        color: #203050;
    }

    .ligne-paiement .reference-paiement {
        color: #647596;
        font-size: 0.76rem;
    }

    .etat-animal {
        display: inline-flex;
        margin-top: 0.45rem;
        border-radius: 999px;
        padding: 0.18rem 0.55rem;
        background: #eaf7ef;
        border: 1px solid #cae7d4;
        color: #2e7551;
        font-size: 0.74rem;
        font-weight: 700;
    }

    .pagination-zone {
        margin-top: 0.9rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        padding-top: 0.35rem;
    }

    .pagination-info {
        color: #62708f;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .pagination-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .pagination-bouton {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        padding: 0.45rem 0.85rem;
        border: 1px solid #cfd9ea;
        background: #fff;
        color: #27425f;
        text-decoration: none;
        font-weight: 700;
        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .pagination-bouton:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(26, 45, 84, 0.08);
        color: #18304d;
    }

    .pagination-bouton.desactive,
    .pagination-bouton[aria-disabled="true"] {
        opacity: 0.45;
        pointer-events: none;
        box-shadow: none;
    }

    @media (max-width: 991px) {
        .grille-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }


        .carte-adoptant .haut {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 767px) {
        .grille-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-adoptants">
    <div class="entete-page">
        <h2>Adoptants</h2>
        <p>Clients ayant validé une adoption avec leurs animaux adoptés et leurs profils.</p>
    </div>

    <div class="grille-stats">
        <div class="carte-stat clients">
            <h3>Clients adoptants</h3>
            <p class="valeur">{{ $adoptants->total() }}</p>
        </div>
        <div class="carte-stat animaux">
            <h3>Animaux adoptés</h3>
            <p class="valeur">{{ $adoptants->getCollection()->sum('animaux_adoptes') }}</p>
        </div>
        <div class="carte-stat par-client">
            <h3>Moyenne par client</h3>
            <p class="valeur">{{ $adoptants->total() > 0 ? number_format($adoptants->getCollection()->sum('animaux_adoptes') / $adoptants->total(), 1, ',', ' ') : '0,0' }}</p>
        </div>
        <div class="carte-stat encaisse">
            <h3>Montant encaissé</h3>
            <p class="valeur">{{ number_format((float) $montantTotalEncaisse, 2, ',', ' ') }} $</p>
        </div>
    </div>

    <div class="liste-adoptants">
        @forelse($adoptants as $adoptant)
            @php
                $photoClient = $adoptant->profile_photo_path ? \Illuminate\Support\Facades\Storage::url($adoptant->profile_photo_path) : null;
                $initialeClient = mb_strtoupper(mb_substr(trim((string) ($adoptant->nom ?? 'C')), 0, 1));
            @endphp

            <article class="carte-adoptant">
                <div class="haut">
                    <div class="profil-client">
                        <span class="avatar-client">
                            @if($photoClient)
                                <img src="{{ $photoClient }}" alt="Photo de profil de {{ $adoptant->nom }}">
                            @else
                                {{ $initialeClient }}
                            @endif
                        </span>
                        <div class="infos-client">
                            <h3>{{ $adoptant->nom }}</h3>
                            <p>{{ $adoptant->email }}</p>
                            <p>{{ $adoptant->telephone ?: 'Téléphone non renseigné' }} · {{ $adoptant->adresse ?: 'Adresse non renseignée' }}</p>
                        </div>
                    </div>
                    <span class="badge-compte">{{ $adoptant->animaux_adoptes }} animal(s) adopté(s)</span>
                </div>

                <div class="corps-adoptant">
                    <div class="bloc-animaux">
                        <p class="titre-bloc">Animaux adoptés</p>
                        <div class="grille-animaux">
                            @forelse($adoptant->demandesAdoption as $demande)
                                @php
                                    $animal = $demande->animal;
                                    $photoAnimal = $animal?->chemin_image_miniature ?: ($animal?->chemin_image ?: null);
                                    $urlPhotoAnimal = $photoAnimal ? \Illuminate\Support\Facades\Storage::url($photoAnimal) : null;
                                    $initialeAnimal = mb_strtoupper(mb_substr(trim((string) ($animal->nom ?? 'A')), 0, 1));
                                    $paiementReussi = $demande->paiementsMobiles->sortByDesc('created_at')->first();
                                    $montantPaye = $demande->paiementsMobiles->where('statut', 'reussi')->sum('montant');
                                    $devisePaye = $paiementReussi?->devise ?? 'USD';
                                @endphp

                                <div class="carte-animal">
                                    <span class="avatar-animal">
                                        @if($urlPhotoAnimal)
                                            <img src="{{ $urlPhotoAnimal }}" alt="Photo de {{ $animal->nom ?? 'animal' }}">
                                        @else
                                            {{ $initialeAnimal }}
                                        @endif
                                    </span>
                                    <div class="infos-animal">
                                        <h4>{{ $animal->nom ?? 'Animal' }}</h4>
                                        <p>{{ $animal->espece ?? 'Espèce non précisée' }} @if(!empty($animal?->race)) · {{ $animal->race }} @endif</p>
                                        <p>{{ $animal->age ? $animal->age.' an(s)' : 'Âge non précisé' }} · {{ $animal->localisation ?: 'Localisation non précisée' }}</p>
                                        <div class="ligne-paiement">
                                            <span>
                                                Montant payé: <strong>{{ number_format((float) $montantPaye, 2, ',', ' ') }} {{ $devisePaye }}</strong>
                                            </span>
                                            @if($paiementReussi)
                                                <span class="reference-paiement">{{ $paiementReussi->reference_interne }}</span>
                                            @endif
                                        </div>
                                        <span class="etat-animal">Adopté</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Aucun animal adopté à afficher.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="carte-adoptant p-3 text-muted">Aucun adoptant trouvé pour le moment.</div>
        @endforelse
    </div>

    <div class="pagination-zone">
        <div class="pagination-info">
            Page {{ $adoptants->currentPage() }} sur {{ $adoptants->lastPage() }}
        </div>

        <div class="pagination-actions" aria-label="Pagination des adoptants">
            <a
                href="{{ $adoptants->previousPageUrl() ?: '#' }}"
                class="pagination-bouton {{ $adoptants->onFirstPage() ? 'desactive' : '' }}"
                aria-disabled="{{ $adoptants->onFirstPage() ? 'true' : 'false' }}"
                @if($adoptants->onFirstPage()) tabindex="-1" @endif
            >
                Précédent
            </a>

            <a
                href="{{ $adoptants->nextPageUrl() ?: '#' }}"
                class="pagination-bouton {{ $adoptants->hasMorePages() ? '' : 'desactive' }}"
                aria-disabled="{{ $adoptants->hasMorePages() ? 'false' : 'true' }}"
                @if(! $adoptants->hasMorePages()) tabindex="-1" @endif
            >
                Suivant
            </a>
        </div>
    </div>
</div>
@endsection
