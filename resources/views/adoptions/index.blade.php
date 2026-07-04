@extends('layouts.app')

@section('content')
<style>
    .page-demandes {
        border: 1px solid #dce5f2;
        border-radius: 16px;
        background: radial-gradient(circle at 0% 0%, #edf2ff, #f7f9fc 38%), #f7f9fc;
        padding: 1rem;
    }

    .entete-demandes {
        margin-bottom: 0.95rem;
    }

    .entete-demandes h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #1c2946;
    }

    .entete-demandes p {
        margin: 0.35rem 0 0;
        color: #637390;
    }

    .liste-demandes {
        display: grid;
        gap: 0.75rem;
    }

    .carte-demande {
        border: 1px solid #d8e2f3;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 7px 20px rgba(26, 43, 84, 0.06);
        overflow: hidden;
    }

    .carte-demande .entete {
        padding: 0.75rem 0.9rem;
        border-bottom: 1px solid #e6edf8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
    }

    .carte-demande .titre {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        color: #213157;
    }

    .sous-titre {
        margin: 0.25rem 0 0;
        color: #6a7b9a;
        font-size: 0.85rem;
    }

    .pastille-statut {
        border-radius: 999px;
        border: 1px solid transparent;
        padding: 0.16rem 0.6rem;
        font-size: 0.74rem;
        font-weight: 700;
    }

    .statut-attente {
        background: #f7efdd;
        border-color: #e8d6af;
        color: #8f6720;
    }

    .statut-approuve {
        background: #e6f2ea;
        border-color: #cde0d3;
        color: #2f6f4f;
    }

    .statut-rejete {
        background: #f7e7eb;
        border-color: #e8cdd4;
        color: #8e3e4d;
    }

    .corps {
        padding: 0.85rem;
        display: grid;
        grid-template-columns: 1.25fr 1.2fr 0.7fr;
        gap: 0.8rem;
    }

    .bloc {
        border: 1px solid #e4ebf6;
        border-radius: 11px;
        background: #fbfcff;
        padding: 0.7rem;
    }

    .bloc h4 {
        margin: 0 0 0.55rem;
        font-size: 0.86rem;
        color: #4a5d83;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
    }

    .profil-client {
        display: flex;
        gap: 0.65rem;
        align-items: flex-start;
    }

    .avatar-client {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: 1px solid #d5e1f3;
        background: linear-gradient(135deg, #3f67f0, #2a4ab6);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        overflow: hidden;
        flex-shrink: 0;
    }

    .avatar-client-bouton {
        padding: 0;
        border: 0;
        background: transparent;
        cursor: zoom-in;
        border-radius: 50%;
    }

    .avatar-client-bouton:focus-visible {
        outline: 2px solid #2f5ad9;
        outline-offset: 2px;
    }

    .avatar-client img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .infos-client p,
    .infos-demande p {
        margin: 0.18rem 0;
        font-size: 0.9rem;
        color: #304264;
    }

    .infos-client .nom,
    .infos-demande .label-fort {
        font-weight: 700;
        color: #1f2f52;
    }

    .message-demande {
        margin-top: 0.45rem;
        border-left: 3px solid #d7e3f5;
        padding-left: 0.55rem;
        color: #314566;
        font-size: 0.9rem;
        line-height: 1.4;
        white-space: pre-wrap;
    }

    .actions form {
        display: grid;
        gap: 0.45rem;
    }

    .actions .form-select {
        min-width: 170px;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .meta-actions {
        font-size: 0.78rem;
        color: #7383a2;
    }

    .demandes-pagination {
        margin-top: 0.85rem;
    }

    .pagination-demandes {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        border: 1px solid #dce5f2;
        border-radius: 12px;
        background: #fff;
        padding: 0.6rem 0.75rem;
    }

    .pagination-demandes .infos {
        margin: 0;
        font-size: 0.85rem;
        color: #5d6f8f;
    }

    .pagination-demandes .actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .apercu-photo {
        position: fixed;
        inset: 0;
        z-index: 1080;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(9, 17, 31, 0.76);
        backdrop-filter: blur(2px);
        padding: 1rem;
    }

    .apercu-photo.est-ouvert {
        display: flex;
    }

    .apercu-photo-contenu {
        position: relative;
        max-width: min(94vw, 860px);
        max-height: 90vh;
    }

    .apercu-photo-image {
        max-width: 100%;
        max-height: 84vh;
        border-radius: 14px;
        border: 1px solid rgba(226, 235, 255, 0.45);
        box-shadow: 0 20px 55px rgba(0, 0, 0, 0.38);
        display: block;
    }

    .apercu-photo-fermer {
        position: absolute;
        top: -12px;
        right: -12px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #f8fbff;
        color: #1b2a4e;
        font-size: 1.2rem;
        line-height: 1;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(16, 25, 48, 0.28);
    }

    @media (max-width: 1100px) {
        .corps {
            grid-template-columns: 1fr;
        }

        .actions .form-select {
            min-width: 100%;
        }
    }
</style>

<div class="page-demandes">
    <div class="entete-demandes">
        <h2>Demandes d'adoption</h2>
        <p>Consultez chaque dossier client, ses informations et mettez à jour le statut de la demande.</p>
    </div>

    <div class="liste-demandes">
        @forelse($requests as $demande)
            @php
                $statutClasse = match ($demande->statut) {
                    'approuve' => 'statut-approuve',
                    'rejete' => 'statut-rejete',
                    default => 'statut-attente',
                };

                $statutLibelle = match ($demande->statut) {
                    'approuve' => 'Approuvée',
                    'rejete' => 'Rejetée',
                    default => 'En attente',
                };

                $client = $demande->utilisateur;
                $photoClient = $client?->profile_photo_path ? \Illuminate\Support\Facades\Storage::url($client->profile_photo_path) : null;
                $initialeClient = mb_strtoupper(mb_substr(trim((string) ($client->nom ?? 'C')), 0, 1));
                $dernierPaiement = $demande->paiementsMobiles->first();
            @endphp

            <article class="carte-demande">
                <div class="entete">
                    <div>
                        <h3 class="titre">{{ $demande->animal->nom ?? 'Animal non défini' }}</h3>
                        <p class="sous-titre">Demande #{{ $demande->id }} · Soumise le {{ $demande->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="pastille-statut {{ $statutClasse }}">{{ $statutLibelle }}</span>
                </div>

                <div class="corps">
                    <section class="bloc">
                        <h4>Client</h4>
                        <div class="profil-client">
                            @if($photoClient)
                                <button
                                    type="button"
                                    class="avatar-client-bouton"
                                    data-apercu-src="{{ $photoClient }}"
                                    data-apercu-alt="Photo de profil de {{ $client->nom ?? 'Client' }}"
                                    aria-label="Afficher la photo de profil de {{ $client->nom ?? 'ce client' }}"
                                >
                                    <span class="avatar-client">
                                        <img src="{{ $photoClient }}" alt="Photo de profil de {{ $client->nom ?? 'Client' }}">
                                    </span>
                                </button>
                            @else
                                <span class="avatar-client" aria-hidden="true">{{ $initialeClient }}</span>
                            @endif
                            <div class="infos-client">
                                <p class="nom">{{ $client->nom ?? 'Client inconnu' }}</p>
                                <p><strong>Email:</strong> {{ $client->email ?? 'Non renseigné' }}</p>
                                <p><strong>Téléphone:</strong> {{ $client->telephone ?: 'Non renseigné' }}</p>
                                <p><strong>Adresse:</strong> {{ $client->adresse ?: 'Non renseignée' }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="bloc">
                        <h4>Détails de la demande</h4>
                        <div class="infos-demande">
                            <p><span class="label-fort">Animal:</span> {{ $demande->animal->nom ?? 'N/A' }} ({{ $demande->animal->espece ?? 'Espèce non précisée' }})</p>
                            <p><span class="label-fort">Localisation:</span> {{ $demande->animal->localisation ?? 'Non précisée' }}</p>
                            <p><span class="label-fort">Date:</span> {{ $demande->created_at?->format('d/m/Y H:i') }}</p>
                            <p><span class="label-fort">Dernier paiement:</span>
                                @if($dernierPaiement)
                                    {{ ucfirst($dernierPaiement->statut) }} · {{ $dernierPaiement->created_at?->format('d/m/Y H:i') }}
                                @else
                                    Aucun paiement enregistré
                                @endif
                            </p>

                            <div class="message-demande">
                                {{ $demande->message ?: 'Aucun message fourni par le client.' }}
                            </div>

                            @if(!empty($demande->notes))
                                <div class="message-demande mt-2">
                                    <strong>Notes internes:</strong> {{ $demande->notes }}
                                </div>
                            @endif
                        </div>
                    </section>

                    <section class="bloc actions">
                        <h4>Actions</h4>
                        <form method="POST" action="{{ route('adoptions.status', $demande) }}">
                            @csrf
                            <label for="statut-{{ $demande->id }}" class="small text-muted">Mettre à jour le statut</label>
                            <select id="statut-{{ $demande->id }}" name="statut" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="en_attente" {{ $demande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="approuve" {{ $demande->statut === 'approuve' ? 'selected' : '' }}>Approuvée</option>
                                <option value="rejete" {{ $demande->statut === 'rejete' ? 'selected' : '' }}>Rejetée</option>
                            </select>
                            <div class="meta-actions">Le changement de statut déclenche une notification au client.</div>
                        </form>
                    </section>
                </div>
            </article>
        @empty
            <div class="carte-demande p-3 text-muted">Aucune demande d'adoption disponible pour le moment.</div>
        @endforelse
    </div>

    <div class="demandes-pagination">
        <div class="pagination-demandes">
            <p class="infos">Page {{ $requests->currentPage() }} sur {{ $requests->lastPage() }} · {{ $requests->total() }} demande(s)</p>
            <div class="actions">
                @if($requests->onFirstPage())
                    <span class="btn btn-sm btn-outline-secondary disabled" aria-disabled="true">Précédent</span>
                @else
                    <a class="btn btn-sm btn-outline-primary" href="{{ $requests->previousPageUrl() }}">Précédent</a>
                @endif

                @if($requests->hasMorePages())
                    <a class="btn btn-sm btn-primary" href="{{ $requests->nextPageUrl() }}">Suivant</a>
                @else
                    <span class="btn btn-sm btn-secondary disabled" aria-disabled="true">Suivant</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="apercu-photo" id="apercu-photo" aria-hidden="true" role="dialog" aria-label="Aperçu photo profil">
    <div class="apercu-photo-contenu">
        <button type="button" class="apercu-photo-fermer" id="apercu-photo-fermer" aria-label="Fermer l'aperçu">×</button>
        <img src="" alt="Aperçu photo profil" class="apercu-photo-image" id="apercu-photo-image">
    </div>
</div>

<script>
    (() => {
        const modal = document.getElementById('apercu-photo');
        const image = document.getElementById('apercu-photo-image');
        const fermer = document.getElementById('apercu-photo-fermer');

        if (!modal || !image || !fermer) {
            return;
        }

        const ouvrir = (src, altText) => {
            image.src = src;
            image.alt = altText || 'Aperçu photo profil';
            modal.classList.add('est-ouvert');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const fermerApercu = () => {
            modal.classList.remove('est-ouvert');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            image.src = '';
        };

        document.addEventListener('click', (event) => {
            const cible = event.target.closest('[data-apercu-src]');
            if (!cible) {
                return;
            }

            ouvrir(cible.getAttribute('data-apercu-src'), cible.getAttribute('data-apercu-alt'));
        });

        fermer.addEventListener('click', fermerApercu);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                fermerApercu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('est-ouvert')) {
                fermerApercu();
            }
        });
    })();
</script>
@endsection
