@extends('layouts.app')

@section('content')
<style>
    .manager-coquille {
        background: linear-gradient(180deg, #f7f9fc 0%, #eef4fb 100%);
        border: 1px solid #dbe5f4;
        border-radius: 18px;
        padding: 0.9rem;
    }

    .manager-entete {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 0.85rem;
    }

    .manager-entete h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .manager-entete p {
        margin: 0.25rem 0 0;
        color: #66758f;
        max-width: 72ch;
    }

    .manager-actions-rapides {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
    }

    .manager-bouton-rapide {
        border-radius: 999px;
        padding: 0.45rem 0.85rem;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid #d4deef;
        background: #fff;
        color: #2b4166;
        font-size: 0.88rem;
    }

    .manager-bouton-rapide:hover {
        background: #eff4fb;
        color: #1f2e4a;
    }

    .manager-grille-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.65rem;
        margin-bottom: 0.85rem;
    }

    .manager-carte-stat {
        border-radius: 14px;
        padding: 0.8rem 0.85rem;
        color: #fff;
        box-shadow: 0 10px 24px rgba(21, 36, 65, 0.1);
    }

    .manager-carte-stat h5 {
        margin: 0 0 0.2rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .manager-carte-stat p {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .manager-carte-stat.animaux { background: #2f7d3f; }
    .manager-carte-stat.demandes { background: #9a730f; }
    .manager-carte-stat.attente { background: #be3f3f; }
    .manager-carte-stat.approuvees { background: #1f5fbf; }

    .manager-grid-sections {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 0.85rem;
    }

    .manager-bloc {
        background: #fff;
        border: 1px solid #dbe5f4;
        border-radius: 16px;
        box-shadow: 0 8px 18px rgba(23, 39, 72, 0.05);
        overflow: hidden;
    }

    .manager-bloc-hd {
        padding: 0.75rem 0.85rem;
        border-bottom: 1px solid #e8eef8;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }

    .manager-bloc-hd h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #203050;
    }

    .manager-bloc-hd span {
        color: #6a7690;
        font-size: 0.84rem;
    }

    .manager-bloc-body {
        padding: 0.85rem;
    }

    .manager-liste {
        display: grid;
        gap: 0.55rem;
    }

    .manager-carte-ligne {
        border: 1px solid #e2eaf6;
        border-radius: 12px;
        padding: 0.7rem 0.75rem;
        background: #fbfcff;
    }

    .manager-carte-ligne h4 {
        margin: 0;
        font-size: 0.93rem;
        font-weight: 800;
        color: #203050;
    }

    .manager-carte-ligne p {
        margin: 0.15rem 0 0;
        color: #62718d;
        font-size: 0.82rem;
    }

    .manager-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.2rem 0.55rem;
        font-size: 0.74rem;
        font-weight: 700;
        background: #edf4ff;
        color: #3151b2;
        margin-top: 0.35rem;
    }

    .manager-carte-mission {
        display: grid;
        gap: 0.55rem;
    }

    .manager-mission {
        border: 1px solid #dbe5f4;
        border-radius: 12px;
        padding: 0.75rem;
        background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
    }

    .manager-mission h4 {
        margin: 0 0 0.15rem;
        font-size: 0.92rem;
        font-weight: 800;
        color: #203050;
    }

    .manager-mission p {
        margin: 0;
        color: #62718d;
        font-size: 0.83rem;
        line-height: 1.45;
    }

    .manager-mini-grille {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.55rem;
        margin-top: 0.5rem;
    }

    .manager-mini-carte {
        border: 1px solid #e3ebf7;
        border-radius: 12px;
        padding: 0.65rem;
        background: #fff;
    }

    .manager-mini-carte strong {
        display: block;
        color: #203050;
    }

    .manager-mini-carte span {
        color: #6b7894;
        font-size: 0.82rem;
    }

    @media (max-width: 991px) {
        .manager-grille-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .manager-grid-sections {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .manager-grille-stats,
        .manager-mini-grille {
            grid-template-columns: 1fr;
        }

        .manager-entete h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="manager-coquille">
    <div class="manager-entete">
        <div>
            <h2>Tableau de bord gestionnaire</h2>
            <p>Le gestionnaire traite les demandes d’adoption, surveille les animaux disponibles et organise le suivi post-adoption. Cet espace concentre ses actions prioritaires.</p>
        </div>
        <div class="manager-actions-rapides">
            <a href="{{ route('adoptions.index') }}" class="manager-bouton-rapide">Voir les demandes</a>
            <a href="{{ route('animals.index') }}" class="manager-bouton-rapide">Gérer les animaux</a>
            <a href="{{ route('admin.suivi.index') }}" class="manager-bouton-rapide">Suivi post-adoption</a>
        </div>
    </div>

    <div class="manager-grille-stats">
        <div class="manager-carte-stat animaux">
            <h5>Animaux totaux</h5>
            <p>{{ $stats['animals_total'] }}</p>
        </div>
        <div class="manager-carte-stat demandes">
            <h5>Demandes totales</h5>
            <p>{{ $stats['requests_total'] }}</p>
        </div>
        <div class="manager-carte-stat attente">
            <h5>Demandes en attente</h5>
            <p>{{ $stats['requests_pending'] }}</p>
        </div>
        <div class="manager-carte-stat approuvees">
            <h5>Demandes approuvées</h5>
            <p>{{ $stats['requests_approved'] }}</p>
        </div>
    </div>

    <div class="manager-grid-sections">
        <section class="manager-bloc">
            <div class="manager-bloc-hd">
                <h3>Priorités métier</h3>
                <span>Ce que le gestionnaire doit traiter</span>
            </div>
            <div class="manager-bloc-body manager-carte-mission">
                <div class="manager-mission">
                    <h4>1. Traiter les demandes d’adoption</h4>
                    <p>Examiner les nouvelles demandes, vérifier la cohérence des messages et décider du statut d’approbation ou de rejet.</p>
                </div>
                <div class="manager-mission">
                    <h4>2. Maintenir le catalogue des animaux</h4>
                    <p>Ajouter, modifier et mettre à jour les fiches des animaux disponibles pour que les clients voient des informations exactes.</p>
                </div>
                <div class="manager-mission">
                    <h4>3. Assurer le suivi post-adoption</h4>
                    <p>Planifier les suivis, noter les observations et garder une vue claire sur les dossiers déjà approuvés.</p>
                </div>
            </div>
        </section>

        <section class="manager-bloc">
            <div class="manager-bloc-hd">
                <h3>État opérationnel</h3>
                <span>Résumé rapide</span>
            </div>
            <div class="manager-bloc-body">
                <div class="manager-mini-grille">
                    <div class="manager-mini-carte">
                        <strong>{{ $stats['animals_disponibles'] }}</strong>
                        <span>Animaux disponibles</span>
                    </div>
                    <div class="manager-mini-carte">
                        <strong>{{ $stats['followups_total'] }}</strong>
                        <span>Suivis créés</span>
                    </div>
                    <div class="manager-mini-carte">
                        <strong>{{ $stats['followups_open'] }}</strong>
                        <span>Suivis ouverts</span>
                    </div>
                    <div class="manager-mini-carte">
                        <strong>{{ $stats['adoptions_sans_paiement'] }}</strong>
                        <span>Adoptions sans paiement validé</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="manager-grid-sections mt-3">
        <section class="manager-bloc">
            <div class="manager-bloc-hd">
                <h3>Demandes à traiter</h3>
                <span>{{ $demandesEnAttente->count() }} demandes récentes</span>
            </div>
            <div class="manager-bloc-body">
                <div class="manager-liste">
                    @forelse($demandesEnAttente as $demande)
                        <div class="manager-carte-ligne">
                            <h4>{{ $demande->animal?->nom ?? 'Animal' }} · {{ $demande->utilisateur?->nom ?? 'Client' }}</h4>
                            <p>{{ $demande->message ?: 'Aucun message fourni.' }}</p>
                            <span class="manager-badge">Statut: {{ $demande->statut }}</span>
                        </div>
                    @empty
                        <div class="manager-carte-ligne">
                            <h4>Aucune demande en attente</h4>
                            <p>Toutes les demandes ont déjà été traitées ou il n’y a pas de nouvelle demande.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="manager-bloc">
            <div class="manager-bloc-hd">
                <h3>Suivi récent</h3>
                <span>Relances et observations</span>
            </div>
            <div class="manager-bloc-body">
                <div class="manager-liste">
                    @forelse($suivisRecents as $suivi)
                        <div class="manager-carte-ligne">
                            <h4>{{ $suivi->demandeAdoption?->animal?->nom ?? 'Animal' }} · {{ $suivi->demandeAdoption?->utilisateur?->nom ?? 'Client' }}</h4>
                            <p>{{ $suivi->notes ?: 'Aucune note de suivi.' }}</p>
                            <span class="manager-badge">{{ $suivi->statut }}</span>
                        </div>
                    @empty
                        <div class="manager-carte-ligne">
                            <h4>Aucun suivi récent</h4>
                            <p>Les suivis post-adoption apparaîtront ici dès qu’ils seront créés.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <section class="manager-bloc mt-3">
        <div class="manager-bloc-hd">
            <h3>Animaux récents</h3>
            <span>Dernières fiches créées ou modifiées</span>
        </div>
        <div class="manager-bloc-body">
            <div class="manager-mini-grille">
                @forelse($animauxRecents as $animal)
                    <div class="manager-mini-carte">
                        <strong>{{ $animal->nom }}</strong>
                        <span>{{ $animal->espece }} · {{ $animal->statut }}</span>
                    </div>
                @empty
                    <div class="manager-mini-carte">
                        <strong>Aucun animal</strong>
                        <span>Les nouvelles fiches apparaîtront ici.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection
