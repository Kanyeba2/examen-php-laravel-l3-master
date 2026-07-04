@extends('layouts.app')

@section('content')
<style>
    .page-cms {
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
        grid-template-columns: 1.25fr 0.85fr;
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

    .badge-etat {
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

    .bloc-page {
        border: 1px solid #e7edf7;
        border-radius: 12px;
        background: #fbfcff;
        padding: 0.7rem;
        margin-top: 0.55rem;
    }

    .bloc-page h5 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 800;
        color: #203050;
    }

    .bloc-page p {
        margin: 0.25rem 0 0;
        color: #5a6c8d;
        font-size: 0.87rem;
        line-height: 1.4;
    }

    .liste-blocs {
        display: grid;
        gap: 0.65rem;
    }

    .carte-bloc {
        border: 1px solid #e3ebf6;
        border-radius: 12px;
        background: #fbfcff;
        padding: 0.72rem;
    }

    .carte-bloc h5 {
        margin: 0;
        font-size: 0.92rem;
        font-weight: 800;
        color: #203050;
    }

    .carte-bloc p {
        margin: 0.22rem 0 0;
        color: #5a6c8d;
        font-size: 0.87rem;
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

<div class="page-cms">
    <div class="entete-page">
        <h2>Pages</h2>
        <p>Gérez les pages du site depuis la base de données avec un rendu plus sobre et plus compact.</p>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi">
            <p class="libelle">Pages publiées</p>
            <p class="valeur">{{ $stats['pages_publiées'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Brouillons</p>
            <p class="valeur">{{ $stats['pages_brouillon'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Archives</p>
            <p class="valeur">{{ $stats['pages_archives'] }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Taux de mise à jour</p>
            <p class="valeur">{{ $stats['taux_maj'] }}</p>
        </div>
    </div>

    <div class="corps-page">
        <section class="bloc">
            <div class="bloc-entete">
                <h3>Pages du site</h3>
                <div class="actions-cms">
                    <a href="{{ route('admin.cms.create', ['type' => 'page']) }}" class="btn btn-sm btn-primary">Nouvelle page</a>
                </div>
            </div>
            <table class="tableau-contenu">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>État</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        @php
                            $badgeClass = match ($page->status) {
                                'published' => 'badge-publie',
                                'archived' => 'badge-archive',
                                default => 'badge-brouillon',
                            };
                            $badgeLabel = match ($page->status) {
                                'published' => 'Publié',
                                'archived' => 'Archivé',
                                default => 'Brouillon',
                            };
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $page->title }}</strong>
                                <div class="text-muted small">{{ $page->summary ?: 'Page du site' }}</div>
                                <div class="bloc-page">
                                    <h5>{{ $page->slug }}</h5>
                                    <p>Dernière mise à jour: {{ $page->published_at?->format('d/m/Y') ?? 'Non publiée' }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="badge-etat {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            </td>
                            <td>
                                <div class="actions-ligne">
                                    <a href="{{ route('admin.cms.edit', $page) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                    <form method="POST" action="{{ route('admin.cms.destroy', $page) }}" onsubmit="return confirm('Supprimer cette page ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Aucune page enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <aside class="bloc">
            <div class="bloc-entete">
                <h3>Blocs modulaires</h3>
            </div>
            <div style="padding: 0.9rem;">
                <div class="liste-blocs">
                    @foreach($blocs as $bloc)
                        <div class="carte-bloc">
                            <h5>{{ $bloc['nom'] }}</h5>
                            <p><strong>État:</strong> {{ $bloc['etat'] }} · <strong>Priorité:</strong> {{ $bloc['priorite'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
