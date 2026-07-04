@extends('layouts.app')

@section('content')
<style>
    .page-contenu {
        background: #f7f9fc;
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 0.95rem;
    }

    .entete-page {
        margin-bottom: 0.95rem;
    }

    .entete-page h2 {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .entete-page p {
        margin: 0.3rem 0 0;
        color: #64728d;
    }

    .grille-kpi {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.7rem;
        margin-bottom: 0.95rem;
    }

    .carte-kpi {
        border-radius: 14px;
        padding: 0.75rem 0.8rem;
        background: #ffffff;
        border: 1px solid #e1e9f5;
        box-shadow: 0 8px 18px rgba(18, 33, 56, 0.04);
    }

    .carte-kpi .libelle {
        margin: 0;
        color: #6b7a96;
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
    }

    .carte-kpi .valeur {
        margin: 0.2rem 0 0;
        font-size: 1.4rem;
        font-weight: 800;
        color: #203050;
    }

    .corps-page {
        display: grid;
        grid-template-columns: 1.35fr 0.85fr;
        gap: 0.85rem;
    }

    .bloc {
        border: 1px solid #e1e9f5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(18, 33, 56, 0.04);
        overflow: hidden;
    }

    .bloc-entete {
        padding: 0.8rem 0.9rem;
        border-bottom: 1px solid #edf2f8;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .bloc-entete h3 {
        margin: 0;
        font-size: 0.98rem;
        font-weight: 800;
        color: #22314f;
    }

    .actions-cms {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge-statut {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.18rem 0.55rem;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .badge-publie {
        background: #edf7f2;
        border-color: #d2eadf;
        color: #2d7a55;
    }

    .badge-brouillon {
        background: #f8f5ea;
        border-color: #e7ddbc;
        color: #8a6a1b;
    }

    .badge-archive {
        background: #eef2f7;
        border-color: #d8e0ec;
        color: #50627f;
    }

    .tableau-contenu {
        width: 100%;
        border-collapse: collapse;
    }

    .tableau-contenu th,
    .tableau-contenu td {
        padding: 0.72rem 0.9rem;
        border-bottom: 1px solid #edf2f8;
        vertical-align: top;
    }

    .tableau-contenu th {
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.72rem;
        color: #72809b;
        background: #fbfcfe;
    }

    .resume-article,
    .resume-conseil {
        margin: 0.3rem 0 0;
        color: #4b5b78;
        line-height: 1.42;
        font-size: 0.88rem;
    }

    .carte-lateral {
        padding: 0.9rem;
    }

    .carte-conseil {
        border: 1px solid #e3ebf6;
        border-radius: 12px;
        background: #fbfcff;
        padding: 0.72rem;
        margin-bottom: 0.65rem;
    }

    .carte-conseil:last-child {
        margin-bottom: 0;
    }

    .carte-conseil h5 {
        margin: 0;
        font-size: 0.92rem;
        font-weight: 800;
        color: #203050;
    }

    .carte-conseil p {
        margin: 0.22rem 0 0;
        color: #5a6c8d;
        font-size: 0.87rem;
        line-height: 1.4;
    }

    .badge-niveau {
        display: inline-flex;
        margin-top: 0.45rem;
        border-radius: 999px;
        padding: 0.16rem 0.5rem;
        font-size: 0.72rem;
        font-weight: 700;
        background: #eef3ff;
        color: #3559c7;
        border: 1px solid #d8e1ff;
    }

    .actions-ligne {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    @media (max-width: 1100px) {
        .grille-kpi,
        .corps-page {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-contenu">
    <div class="entete-page">
        <h2>Articles / Conseils</h2>
        <p>Publiez et gérez des contenus éditoriaux depuis la base de données, avec un rendu sobre et corporate.</p>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi">
            <p class="libelle">Articles publiés</p>
            <p class="valeur">{{ $stats['articles_publies'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Brouillons</p>
            <p class="valeur">{{ $stats['brouillons'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Publications du mois</p>
            <p class="valeur">{{ $stats['publications_mois'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Conseils actifs</p>
            <p class="valeur">{{ $stats['conseils_actifs'] }}</p>
        </div>
    </div>

    <div class="corps-page">
        <section class="bloc">
            <div class="bloc-entete">
                <h3>Contenus éditoriaux</h3>
                <div class="actions-cms">
                    <a href="{{ route('admin.cms.create', ['type' => 'article']) }}" class="btn btn-sm btn-primary">Nouvel article</a>
                    <a href="{{ route('admin.cms.create', ['type' => 'conseil']) }}" class="btn btn-sm btn-outline-primary">Nouveau conseil</a>
                </div>
            </div>
            <table class="tableau-contenu">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>
                                <strong>{{ $article->title }}</strong>
                                <p class="resume-article">{{ $article->summary ?: 'Aucun résumé disponible.' }}</p>
                                <div class="text-muted small mt-1">{{ $article->category ?: 'Article' }} · {{ $article->published_at?->format('d/m/Y') ?? 'Non publié' }}</div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match ($article->status) {
                                        'published' => 'badge-publie',
                                        'archived' => 'badge-archive',
                                        default => 'badge-brouillon',
                                    };
                                    $badgeLabel = match ($article->status) {
                                        'published' => 'Publié',
                                        'archived' => 'Archivé',
                                        default => 'Brouillon',
                                    };
                                @endphp
                                <span class="badge-statut {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            </td>
                            <td>
                                <div class="actions-ligne">
                                    <a href="{{ route('admin.cms.edit', $article) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                    <form method="POST" action="{{ route('admin.cms.destroy', $article) }}" onsubmit="return confirm('Supprimer cet article ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Aucun article enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <aside class="bloc">
            <div class="bloc-entete">
                <h3>Conseils rapides</h3>
            </div>
            <div class="carte-lateral">
                @forelse($conseils as $conseil)
                    <div class="carte-conseil">
                        <h5>{{ $conseil->title }}</h5>
                        <p>{{ $conseil->summary ?: 'Conseil publié par l’équipe éditoriale.' }}</p>
                        @php
                            $badgeClass = match ($conseil->status) {
                                'published' => 'badge-publie',
                                'archived' => 'badge-archive',
                                default => 'badge-brouillon',
                            };
                            $badgeLabel = match ($conseil->status) {
                                'published' => 'Publié',
                                'archived' => 'Archivé',
                                default => 'Brouillon',
                            };
                        @endphp
                        <span class="badge-statut {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        <span class="badge-niveau">{{ $conseil->is_featured ? 'Mis en avant' : 'Standard' }}</span>
                    </div>
                @empty
                    <div class="text-muted">Aucun conseil enregistré.</div>
                @endforelse
            </div>
        </aside>
    </div>
</div>
@endsection
