@extends('layouts.app')

@section('content')
<style>
    .page-suivi {
        background: linear-gradient(180deg, #f6f8fc 0%, #eef4fb 100%);
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

    .carte-stat.total { background: linear-gradient(135deg, #264a86, #1f3562); }
    .carte-stat.cours { background: linear-gradient(135deg, #8a5c12, #6e4a0e); }
    .carte-stat.prochaine { background: linear-gradient(135deg, #1f7a4d, #15563c); }
    .carte-stat.termine { background: linear-gradient(135deg, #7a3ea5, #5a2f7f); }

    .liste-suivis {
        display: grid;
        gap: 0.9rem;
    }

    .carte-suivi {
        border: 1px solid #dbe5f4;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(23, 39, 72, 0.06);
        overflow: hidden;
    }

    .carte-suivi .haut {
        padding: 0.85rem 0.95rem;
        border-bottom: 1px solid #e6edf8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .profil-client,
    .profil-animal {
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

    .infos h3,
    .infos h4,
    .infos p {
        margin: 0;
    }

    .infos h3,
    .infos h4 {
        font-size: 1rem;
        font-weight: 800;
        color: #203050;
    }

    .infos p {
        font-size: 0.9rem;
        color: #637292;
        margin-top: 0.12rem;
    }

    .badge-suivi {
        border-radius: 999px;
        padding: 0.25rem 0.7rem;
        font-size: 0.78rem;
        font-weight: 700;
        background: #edf4ff;
        border: 1px solid #d7e5ff;
        color: #2c56c8;
        white-space: nowrap;
    }

    .corps-suivi {
        padding: 0.95rem;
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: 0.75rem;
    }

    .bloc {
        border: 1px solid #e4ebf7;
        border-radius: 14px;
        background: #fbfcff;
        padding: 0.85rem;
    }

    .bloc h5 {
        margin: 0 0 0.65rem;
        font-size: 0.84rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #5a6c8d;
    }

    .message-suivi {
        margin-top: 0.45rem;
        border-left: 3px solid #d7e3f5;
        padding-left: 0.55rem;
        color: #314566;
        font-size: 0.9rem;
        line-height: 1.45;
        white-space: pre-wrap;
    }

    .etat {
        display: inline-flex;
        margin-top: 0.55rem;
        border-radius: 999px;
        padding: 0.18rem 0.55rem;
        font-size: 0.74rem;
        font-weight: 700;
    }

    .etat.encours {
        background: #f7efdd;
        border: 1px solid #e8d6af;
        color: #8f6720;
    }

    .etat.termine {
        background: #e6f2ea;
        border: 1px solid #cde0d3;
        color: #2f6f4f;
    }

    .etat.autre {
        background: #ebeff8;
        border: 1px solid #d7e1f2;
        color: #4c5f84;
    }

    .timeline {
        display: grid;
        gap: 0.45rem;
        color: #344867;
        font-size: 0.9rem;
    }

    .pagination-zone {
        margin-top: 0.9rem;
    }

    @media (max-width: 1100px) {
        .grille-stats,
        .corps-suivi {
            grid-template-columns: 1fr;
        }

        .carte-suivi .haut {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="page-suivi">
    <div class="entete-page">
        <h2>Suivi post-adoption</h2>
        <p>Suivi des animaux adoptés auprès des clients, avec les prochaines étapes et les notes de terrain.</p>
    </div>

    <div class="grille-stats">
        <div class="carte-stat total">
            <h3>Suivis enregistrés</h3>
            <p class="valeur">{{ $suivis->total() }}</p>
        </div>
        <div class="carte-stat cours">
            <h3>En cours</h3>
            <p class="valeur">{{ $suivis->getCollection()->where('statut', 'en_cours')->count() }}</p>
        </div>
        <div class="carte-stat prochaine">
            <h3>Prochaine étape</h3>
            <p class="valeur">{{ $suivis->getCollection()->whereNotNull('date_prochaine_etape')->count() }}</p>
        </div>
        <div class="carte-stat termine">
            <h3>Terminés</h3>
            <p class="valeur">{{ $suivis->getCollection()->where('statut', 'termine')->count() }}</p>
        </div>
    </div>

    <div class="liste-suivis">
        @forelse($suivis as $suivi)
            @php
                $demande = $suivi->demandeAdoption;
                $client = $demande?->utilisateur;
                $animal = $demande?->animal;
                $photoClient = $client?->profile_photo_path ? \Illuminate\Support\Facades\Storage::url($client->profile_photo_path) : null;
                $photoAnimal = $animal?->chemin_image_miniature ?: ($animal?->chemin_image ?: null);
                $urlPhotoAnimal = $photoAnimal ? \Illuminate\Support\Facades\Storage::url($photoAnimal) : null;
                $initialeClient = mb_strtoupper(mb_substr(trim((string) ($client->nom ?? 'C')), 0, 1));
                $initialeAnimal = mb_strtoupper(mb_substr(trim((string) ($animal->nom ?? 'A')), 0, 1));
                $classeEtat = match ($suivi->statut) {
                    'termine' => 'termine',
                    'en_cours' => 'encours',
                    default => 'autre',
                };
            @endphp

            <article class="carte-suivi">
                <div class="haut">
                    <div class="profil-client">
                        <span class="avatar-client">
                            @if($photoClient)
                                <img src="{{ $photoClient }}" alt="Photo de profil de {{ $client->nom ?? 'Client' }}">
                            @else
                                {{ $initialeClient }}
                            @endif
                        </span>
                        <div class="infos">
                            <h3>{{ $client->nom ?? 'Client inconnu' }}</h3>
                            <p>{{ $client->email ?? 'Email non renseigné' }}</p>
                        </div>
                    </div>

                    <span class="badge-suivi">{{ $suivi->date_prochaine_etape ? 'Étape planifiée' : 'À suivre' }}</span>
                </div>

                <div class="corps-suivi">
                    <section class="bloc">
                        <h5>Animal adopté</h5>
                        <div class="profil-animal">
                            <span class="avatar-animal">
                                @if($urlPhotoAnimal)
                                    <img src="{{ $urlPhotoAnimal }}" alt="Photo de {{ $animal->nom ?? 'animal' }}">
                                @else
                                    {{ $initialeAnimal }}
                                @endif
                            </span>
                            <div class="infos">
                                <h4>{{ $animal->nom ?? 'Animal' }}</h4>
                                <p>{{ $animal->espece ?? 'Espèce non précisée' }}</p>
                                <p>{{ $animal->localisation ?: 'Localisation non précisée' }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="bloc">
                        <h5>Suivi</h5>
                        <div class="timeline">
                            <div><strong>Statut:</strong> {{ ucfirst(str_replace('_', ' ', $suivi->statut)) }}</div>
                            <div><strong>Prochaine étape:</strong> {{ $suivi->date_prochaine_etape ? $suivi->date_prochaine_etape->format('d/m/Y') : 'Non planifiée' }}</div>
                            <div><strong>Créé le:</strong> {{ $suivi->created_at?->format('d/m/Y H:i') }}</div>
                        </div>
                    </section>

                    <section class="bloc">
                        <h5>Notes</h5>
                        <div class="message-suivi">{{ $suivi->notes }}</div>
                        <span class="etat {{ $classeEtat }}">{{ ucfirst(str_replace('_', ' ', $suivi->statut)) }}</span>
                    </section>
                </div>
            </article>
        @empty
            <div class="carte-suivi p-3 text-muted">Aucun suivi post-adoption enregistré pour le moment.</div>
        @endforelse
    </div>

    <div class="pagination-zone">
        {{ $suivis->links() }}
    </div>
</div>
@endsection
