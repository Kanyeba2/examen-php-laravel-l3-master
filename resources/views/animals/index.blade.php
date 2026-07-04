@extends('layouts.app')

@section('content')
<style>
    .animaux-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .animaux-entete {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: .75rem;
        margin-bottom: .9rem;
    }

    .animaux-titre {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .animaux-sous-titre {
        color: #5f6b66;
        margin: .2rem 0 0;
        font-size: .92rem;
    }

    .panneau-filtres {
        background: #f1f5f1;
        border: 1px solid #e0e8e2;
        border-radius: 14px;
        padding: .8rem;
        margin-bottom: 1rem;
    }

    .panneau-filtres .form-control,
    .panneau-filtres .form-select,
    .panneau-filtres .btn {
        height: 42px;
        border-radius: 10px;
    }

    #resultats-recherche-animaux {
        max-height: 260px;
        overflow: auto;
        border: 1px solid #d7e2da;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(26, 37, 30, .08);
    }

    .grille-animaux {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .85rem;
    }

    .carte-animal {
        background: #fff;
        border: 1px solid #dfe8e0;
        border-radius: 12px;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 2px 8px rgba(33, 46, 38, .05);
        height: 100%;
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateY(10px);
        animation: apparitionAnimal .45s ease forwards;
    }

    .carte-animal:nth-child(1) { animation-delay: .03s; }
    .carte-animal:nth-child(2) { animation-delay: .06s; }
    .carte-animal:nth-child(3) { animation-delay: .09s; }
    .carte-animal:nth-child(4) { animation-delay: .12s; }
    .carte-animal:nth-child(5) { animation-delay: .15s; }
    .carte-animal:nth-child(6) { animation-delay: .18s; }
    .carte-animal:nth-child(7) { animation-delay: .21s; }
    .carte-animal:nth-child(8) { animation-delay: .24s; }
    .carte-animal:nth-child(9) { animation-delay: .27s; }
    .carte-animal:nth-child(10) { animation-delay: .30s; }

    @keyframes apparitionAnimal {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .carte-animal:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(33, 46, 38, .12);
    }

    .couverture-animal {
        position: relative;
        background: linear-gradient(110deg, #ecf1ed 18%, #f7faf8 34%, #ecf1ed 49%);
        background-size: 200% 100%;
        animation: pulsationChargement 1.2s linear infinite;
    }

    @keyframes pulsationChargement {
        to {
            background-position-x: -200%;
        }
    }

    .couverture-animal img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
        opacity: 0;
        transition: opacity .25s ease;
    }

    .couverture-animal img.est-chargee {
        opacity: 1;
    }

    .couverture-animal.est-prete {
        animation: none;
        background: #f0f4f0;
    }

    .badge-animal {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: .68rem;
        border-radius: 999px;
        padding: .2rem .5rem;
        color: #fff;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: .01em;
    }

    .badge-animal.statut-disponible { background: #2f7d3f; }
    .badge-animal.statut-en_attente { background: #9a730f; }
    .badge-animal.statut-adopte { background: #465774; }

    .btn-favori {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 25px;
        height: 25px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .78);
        background: rgba(255, 255, 255, .7);
        display: grid;
        place-items: center;
        font-size: .8rem;
        color: #4b5563;
        cursor: pointer;
    }

    .btn-favori.est-favori {
        color: #b45309;
        background: rgba(255, 243, 222, .9);
        border-color: rgba(245, 202, 132, .95);
    }

    .corps-animal {
        padding: .75rem;
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }

    .nom-animal {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #12202f;
    }

    .meta-animal {
        margin: 0;
        color: #516152;
        font-size: .84rem;
    }

    .lieu-animal {
        margin-bottom: .1rem;
        font-size: .82rem;
        color: #2f3f33;
    }

    .actions-animal {
        margin-top: auto;
        display: flex;
        gap: .4rem;
        flex-wrap: wrap;
    }

    .actions-animal .btn {
        border-radius: 9px;
        padding: .3rem .6rem;
        font-size: .78rem;
    }

    .etat-vide {
        border: 1px dashed #c7d4c9;
        background: #f8fbf8;
        color: #4e5c53;
        border-radius: 12px;
        padding: 1.2rem;
        text-align: center;
    }

    .pastille-favoris {
        background: #fff4dd;
        border: 1px solid #efd8a8;
        color: #8a6400;
        padding: .24rem .6rem;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
    }

    @media (max-width: 1199px) {
        .grille-animaux { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 767px) {
        .animaux-titre { font-size: 1.6rem; }
        .animaux-entete { align-items: start; flex-direction: column; }
        .grille-animaux { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    }

    .pagination-coquille {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #5f6b66;
        font-size: .9rem;
    }

    .pagination-actions {
        display: flex;
        gap: .55rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-pagination {
        border-radius: 9px;
        min-width: 125px;
    }

    .pagination-pages {
        display: flex;
        gap: .35rem;
        align-items: center;
    }

    .pagination-page {
        min-width: 38px;
        height: 38px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid #d4ddd6;
        color: #394b41;
        background: #fff;
        font-weight: 600;
        font-size: .82rem;
    }

    .pagination-page:hover {
        border-color: #9eb5a4;
        color: #223327;
        background: #f5f9f6;
    }

    .pagination-page.active {
        border-color: #2f7d3f;
        background: #2f7d3f;
        color: #fff;
        pointer-events: none;
    }

    .pagination-points {
        color: #7b8780;
        font-weight: 700;
        padding: 0 .1rem;
    }
</style>

<div class="animaux-coquille">
    <div class="animaux-entete">
        <div>
            <h2 class="animaux-titre">Animaux disponibles</h2>
            <p class="animaux-sous-titre">Decouvrez les compagnons qui attendent une nouvelle famille.</p>
        </div>
        @can('manage-animals')
            <a href="{{ route('animals.create') }}" class="btn btn-success">Ajouter un animal</a>
        @endcan
    </div>

    <form method="GET" class="panneau-filtres row g-2">
        <div class="col-xl-5 col-lg-12">
            <input type="text" id="recherche-live-animal" name="search" class="form-control" placeholder="Rechercher un animal (nom, espece, race...)" value="{{ request('search') }}">
            <div id="resultats-recherche-animaux" class="list-group mt-2" style="display:none;"></div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6">
            <select name="espece" class="form-select">
                <option value="">Toutes les especes</option>
                @foreach($especes as $espece)
                    <option value="{{ $espece }}" {{ request('espece') === $espece ? 'selected' : '' }}>{{ $espece }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-1 col-lg-4 col-md-6">
            <select name="age_bucket" class="form-select">
                <option value="">Age</option>
                <option value="1" {{ request('age_bucket') == '1' ? 'selected' : '' }}>1 an</option>
                <option value="3" {{ request('age_bucket') == '3' ? 'selected' : '' }}>3 ans</option>
                <option value="5" {{ request('age_bucket') == '5' ? 'selected' : '' }}>5 ans</option>
                <option value="10" {{ request('age_bucket') == '10' ? 'selected' : '' }}>10 ans+</option>
            </select>
        </div>
        <div class="col-xl-1 col-lg-4 col-md-6">
            <select name="taille" class="form-select">
                <option value="">Taille</option>
                <option value="small" {{ request('taille') == 'small' ? 'selected' : '' }}>S</option>
                <option value="medium" {{ request('taille') == 'medium' ? 'selected' : '' }}>M</option>
                <option value="large" {{ request('taille') == 'large' ? 'selected' : '' }}>L</option>
            </select>
        </div>
        <div class="col-xl-1 col-lg-6 col-md-6">
            <input type="text" name="lieu" class="form-control" placeholder="Lieu" value="{{ request('lieu') }}">
        </div>
        <div class="col-xl-2 col-lg-6 col-md-12">
            <button class="btn btn-success w-100">Rechercher</button>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <select name="statut" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="disponible" {{ request('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="adopte" {{ request('statut') == 'adopte' ? 'selected' : '' }}>Adopte</option>
            </select>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <select name="genre" class="form-select">
                <option value="">Tous les genres</option>
                <option value="male" {{ request('genre') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ request('genre') == 'female' ? 'selected' : '' }}>Femelle</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6">
            <select name="sort" class="form-select">
                <option value="">Tri: plus recents</option>
                <option value="age_asc" {{ request('sort') == 'age_asc' ? 'selected' : '' }}>Age croissant</option>
                <option value="age_desc" {{ request('sort') == 'age_desc' ? 'selected' : '' }}>Age decroissant</option>
                <option value="nom_asc" {{ request('sort') == 'nom_asc' ? 'selected' : '' }}>Nom A-Z</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6">
            <select name="favoris_only" class="form-select">
                <option value="">Tous les animaux</option>
                <option value="1" {{ request('favoris_only') == '1' ? 'selected' : '' }}>Mes favoris</option>
            </select>
        </div>
        <div class="col-xl-1 col-lg-2 col-md-6">
            <input type="number" min="0" name="age_min" class="form-control" placeholder="Age min" value="{{ request('age_min') }}">
        </div>
        <div class="col-xl-1 col-lg-2 col-md-6">
            <input type="number" min="0" name="age_max" class="form-control" placeholder="Age max" value="{{ request('age_max') }}">
        </div>
        <div class="col-xl-2 col-lg-4 col-md-12 d-grid">
            <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">Reinitialiser</a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Animaux a adopter</h5>
        <div class="d-flex align-items-center gap-2">
            @if($favoriteAnimalIds->isNotEmpty())
                <span class="pastille-favoris">{{ $favoriteAnimalIds->count() }} favori(s)</span>
            @endif
            <small class="text-muted">{{ $animals->total() }} resultat(s)</small>
        </div>
    </div>

    @if($animals->isEmpty())
        <div class="etat-vide">
            Aucun animal ne correspond a vos filtres pour le moment.
        </div>
    @else
        <div class="grille-animaux">
            @foreach($animals as $animal)
                @php
                    $imageChienParDefaut = 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?q=80&w=640&auto=format&fit=crop';
                    $imageChatParDefaut = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=640&auto=format&fit=crop';
                    $imageGeneriqueParDefaut = 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=640&auto=format&fit=crop';

                    $especeMinuscule = strtolower((string) $animal->espece);
                    $imageSecours = str_contains($especeMinuscule, 'chat')
                        ? $imageChatParDefaut
                        : (str_contains($especeMinuscule, 'chien') ? $imageChienParDefaut : $imageGeneriqueParDefaut);

                    $urlImage = $animal->chemin_image
                        ? \Illuminate\Support\Facades\Storage::url($animal->chemin_image_miniature ?: $animal->chemin_image)
                        : $imageSecours;

                    $classeStatut = 'statut-' . $animal->statut;
                    $estFavori = $favoriteAnimalIds->contains($animal->id);
                @endphp

                <article class="carte-animal">
                    <div class="couverture-animal">
                        <img src="{{ $urlImage }}" alt="Photo de {{ $animal->nom }}" loading="lazy" data-image-animal>
                        <span class="badge-animal {{ $classeStatut }}">{{ str_replace('_', ' ', $animal->statut) }}</span>
                        <form method="POST" action="{{ route('animals.favorite.toggle', $animal) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-favori {{ $estFavori ? 'est-favori' : '' }}" aria-label="Basculer favori">{{ $estFavori ? '♥' : '♡' }}</button>
                        </form>
                    </div>

                    <div class="corps-animal">
                        <h6 class="nom-animal">{{ $animal->nom }}</h6>
                        <p class="meta-animal">{{ $animal->espece }} · {{ $animal->age ?? '?' }} ans · {{ $animal->genre === 'female' ? 'Femelle' : 'Male' }}</p>
                        <div class="lieu-animal">{{ $animal->localisation ?? 'Localisation non precisee' }}</div>

                        <p class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($animal->description, 72) }}</p>

                        <div class="actions-animal">
                            <a href="{{ route('animals.show', $animal) }}" class="btn btn-outline-primary">Voir plus</a>
                            @if(auth()->user()?->role === 'client' && $animal->statut === 'disponible')
                                <a href="{{ route('adoptions.create', $animal) }}" class="btn btn-success">Adopter</a>
                            @endif
                            @if($animal->chemin_document)
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($animal->chemin_document) }}" target="_blank" class="btn btn-outline-info">PDF</a>
                            @endif
                            @can('manage-animals')
                                <a href="{{ route('animals.edit', $animal) }}" class="btn btn-outline-secondary">Modifier</a>
                                <form method="POST" action="{{ route('animals.destroy', $animal) }}" onsubmit="return confirm('Supprimer cet animal ?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if($animals->hasPages())
        @php
            $current = $animals->currentPage();
            $last = $animals->lastPage();
            $start = max(1, $current - 1);
            $end = min($last, $current + 1);
        @endphp
        <div class="pagination-coquille">
            <div class="pagination-info">
                Page {{ $animals->currentPage() }} sur {{ $animals->lastPage() }}
            </div>
            <div class="pagination-actions">
                @if($animals->onFirstPage())
                    <span class="btn btn-outline-secondary btn-pagination disabled" aria-disabled="true">Precedent</span>
                @else
                    <a href="{{ $animals->previousPageUrl() }}" class="btn btn-outline-secondary btn-pagination js-lien-pagination">Precedent</a>
                @endif

                <div class="pagination-pages" aria-label="Pagination">
                    @if($start > 1)
                        <a href="{{ $animals->url(1) }}" class="pagination-page js-lien-pagination">1</a>
                        @if($start > 2)
                            <span class="pagination-points">...</span>
                        @endif
                    @endif

                    @for($page = $start; $page <= $end; $page++)
                        <a href="{{ $animals->url($page) }}" class="pagination-page {{ $page === $current ? 'active' : '' }} js-lien-pagination">{{ $page }}</a>
                    @endfor

                    @if($end < $last)
                        @if($end < $last - 1)
                            <span class="pagination-points">...</span>
                        @endif
                        <a href="{{ $animals->url($last) }}" class="pagination-page js-lien-pagination">{{ $last }}</a>
                    @endif
                </div>

                @if($animals->hasMorePages())
                    <a href="{{ $animals->nextPageUrl() }}" class="btn btn-success btn-pagination js-lien-pagination">Suivant</a>
                @else
                    <span class="btn btn-success btn-pagination disabled" aria-disabled="true">Suivant</span>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
    const entreeRechercheLive = document.getElementById('recherche-live-animal');
    const blocResultatsLive = document.getElementById('resultats-recherche-animaux');
    let minuteurRechercheLive;

    function masquerResultatsLive() {
        blocResultatsLive.style.display = 'none';
        blocResultatsLive.innerHTML = '';
    }

    entreeRechercheLive?.addEventListener('input', () => {
        const terme = entreeRechercheLive.value.trim();

        clearTimeout(minuteurRechercheLive);
        if (terme.length < 2) {
            masquerResultatsLive();
            return;
        }

        minuteurRechercheLive = setTimeout(async () => {
            try {
                const reponse = await fetch(`{{ route('animals.live-search') }}?q=${encodeURIComponent(terme)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await reponse.json();
                const elements = json.data || [];

                if (!elements.length) {
                    masquerResultatsLive();
                    return;
                }

                blocResultatsLive.innerHTML = elements.map((element) => (
                    `<a href="${element.url}" class="list-group-item list-group-item-action">`
                    + `<div class="fw-semibold">${element.nom}</div>`
                    + `<small class="text-muted">${element.espece} - ${element.statut}</small>`
                    + `</a>`
                )).join('');
                blocResultatsLive.style.display = 'block';
            } catch (error) {
                masquerResultatsLive();
            }
        }, 250);
    });

    document.addEventListener('click', (evenement) => {
        if (!blocResultatsLive.contains(evenement.target) && evenement.target !== entreeRechercheLive) {
            masquerResultatsLive();
        }
    });
</script>
<script>
    const liensPagination = document.querySelectorAll('.js-lien-pagination');

    liensPagination.forEach((lien) => {
        lien.addEventListener('click', () => {
            sessionStorage.setItem('animals-scroll-y', String(window.scrollY));
        });
    });

    const hasPageParam = /(^|&)page=/.test(window.location.search.replace(/^\?/, ''));
    const savedScroll = sessionStorage.getItem('animals-scroll-y');

    if (hasPageParam && savedScroll !== null) {
        window.scrollTo({ top: Number(savedScroll), behavior: 'auto' });
        sessionStorage.removeItem('animals-scroll-y');
    }

    document.querySelectorAll('[data-image-animal]').forEach((image) => {
        const marquerChargee = () => {
            image.classList.add('est-chargee');
            image.closest('.couverture-animal')?.classList.add('est-prete');
        };

        if (image.complete) {
            marquerChargee();
        } else {
            image.addEventListener('load', marquerChargee, { once: true });
            image.addEventListener('error', marquerChargee, { once: true });
        }
    });
</script>
@endsection
