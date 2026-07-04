@extends('layouts.app')

@section('content')
<style>
    .page-cms-public {
        background: linear-gradient(180deg, #f7f9fc 0%, #eef3fa 100%);
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 1rem;
    }

    .entete-page {
        margin-bottom: 1rem;
    }

    .entete-page h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .entete-page p {
        margin: 0.35rem 0 0;
        color: #62708f;
    }

    .grille-kpi {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .carte-kpi {
        border-radius: 14px;
        padding: 0.8rem;
        background: #fff;
        border: 1px solid #e3ebf6;
        box-shadow: 0 8px 20px rgba(23, 39, 72, 0.05);
    }

    .carte-kpi .libelle {
        margin: 0;
        color: #6a7b9a;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
    }

    .carte-kpi .valeur {
        margin: 0.25rem 0 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1f2e4a;
    }

    .grille-contenu {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 0.9rem;
    }

    .bloc {
        border: 1px solid #e3ebf6;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(23, 39, 72, 0.05);
        overflow: hidden;
    }

    .bloc-entete {
        padding: 0.85rem 0.95rem;
        border-bottom: 1px solid #edf2f8;
    }

    .bloc-entete h2,
    .bloc-entete h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #22314f;
    }

    .liste-cartes {
        display: grid;
        gap: 0.75rem;
        padding: 0.95rem;
    }

    .carte-contenu {
        border: 1px solid #e4ebf7;
        border-radius: 12px;
        background: #fbfcff;
        padding: 0.8rem;
    }

    .carte-contenu h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #203050;
    }

    .carte-contenu p {
        margin: 0.3rem 0 0;
        color: #5a6c8d;
        line-height: 1.45;
        font-size: 0.9rem;
    }

    .badge-type {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.2rem 0.6rem;
        font-size: 0.74rem;
        font-weight: 700;
        background: #eef3ff;
        color: #3459c8;
        border: 1px solid #d8e1ff;
    }

    .sidebar-conseils {
        padding: 0.95rem;
    }

    .sidebar-conseils .item {
        border: 1px solid #e4ebf7;
        border-radius: 12px;
        background: #fff;
        padding: 0.75rem;
        margin-bottom: 0.7rem;
    }

    .sidebar-conseils .item h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 800;
        color: #203050;
    }

    .sidebar-conseils .item p {
        margin: 0.25rem 0 0;
        color: #5a6c8d;
        font-size: 0.88rem;
        line-height: 1.45;
    }

    @media (max-width: 1100px) {
        .grille-kpi,
        .grille-contenu {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-cms-public">
    <div class="entete-page">
        <h1>Conseils d’adoption</h1>
        <p>Les contenus publiés par l’équipe éditoriale pour accompagner les adoptants avant et après l’adoption.</p>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi">
            <p class="libelle">Articles publiés</p>
            <p class="valeur">{{ $articles->count() }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Conseils actifs</p>
            <p class="valeur">{{ $conseils->count() }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Contenus récents</p>
            <p class="valeur">{{ $articles->count() + $conseils->count() }}</p>
        </div>
    </div>

    <div class="grille-contenu">
        <section class="bloc">
            <div class="bloc-entete">
                <h2>Articles et guides</h2>
            </div>
            <div class="liste-cartes">
                @forelse($articles as $article)
                    <article class="carte-contenu">
                        <span class="badge-type">{{ $article->category ?: 'Article' }}</span>
                        <h3>{{ $article->title }}</h3>
                        <p>{{ $article->summary ?: 'Aucun résumé disponible.' }}</p>
                        <p class="small text-muted mt-2 mb-0">Publié le {{ $article->published_at?->format('d/m/Y') ?? 'N/A' }}</p>
                    </article>
                @empty
                    <div class="text-muted">Aucun article publié pour le moment.</div>
                @endforelse
            </div>
        </section>

        <aside class="bloc">
            <div class="bloc-entete">
                <h3>Conseils rapides</h3>
            </div>
            <div class="sidebar-conseils">
                @forelse($conseils as $conseil)
                    <div class="item">
                        <h4>{{ $conseil->title }}</h4>
                        <p>{{ $conseil->summary ?: 'Conseil publié par l’équipe éditoriale.' }}</p>
                    </div>
                @empty
                    <div class="text-muted">Aucun conseil publié pour le moment.</div>
                @endforelse
            </div>
        </aside>
    </div>
</div>
@endsection
