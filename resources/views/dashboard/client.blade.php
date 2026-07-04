@extends('layouts.app')

@section('content')
<style>
    .client-coquille {
        background: #f6f8f6;
        border: 1px solid #e7ece7;
        border-radius: 18px;
        padding: 1rem;
    }

    .client-banniere {
        border-radius: 16px;
        border: 1px solid #e2e9e3;
        padding: 1.35rem;
        background:
            radial-gradient(circle at 82% 35%, rgba(222, 234, 220, 0.92) 0, rgba(222, 234, 220, 0.92) 28%, transparent 29%),
            linear-gradient(180deg, #f7fbf7 0%, #edf3ec 100%);
        position: relative;
        overflow: hidden;
    }

    .illustration-heros {
        position: absolute;
        right: 12px;
        bottom: 0;
        width: 310px;
        max-width: 33%;
        border-radius: 12px 12px 0 0;
        object-fit: cover;
        opacity: .97;
    }

    .recherche-rapide .form-control,
    .recherche-rapide .form-select,
    .recherche-rapide .btn {
        height: 42px;
        border-radius: 10px;
    }

    .carte-mini-stats {
        border: 1px solid #e4e8e3;
        border-radius: 12px;
        background: #fff;
        padding: .8rem .95rem;
        min-height: 73px;
    }

    .titre-tableau {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .carte-animal-mini {
        border: 1px solid #e3e8e2;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        height: 100%;
    }

    .couverture-animal-mini {
        position: relative;
    }

    .couverture-animal-mini img {
        width: 100%;
        height: 145px;
        object-fit: cover;
        display: block;
    }

    .badge-animal-mini {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: .65rem;
        border-radius: 12px;
        background: #2f7d3f;
        color: #fff;
        padding: .18rem .5rem;
        letter-spacing: .02em;
    }

    .bouton-favori-mini {
        position: absolute;
        right: 8px;
        top: 8px;
        width: 24px;
        height: 24px;
        border: 1px solid rgba(255, 255, 255, .8);
        background: rgba(255, 255, 255, .65);
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: .75rem;
    }

    .corps-animal-mini {
        padding: .7rem .78rem .8rem;
    }

    .meta-animal-mini {
        color: #4b5563;
        font-size: .82rem;
    }

    .lieu-animal-mini {
        color: #6b7280;
        font-size: .78rem;
        margin-top: .25rem;
    }

    .panneau-section {
        border: 1px solid #e3e8e2;
        border-radius: 12px;
        background: #fff;
        padding: .95rem;
        height: 100%;
    }

    .titre-section {
        font-size: 1.12rem;
        font-weight: 600;
    }

    .element-demande {
        border-top: 1px solid #eef2ee;
        padding-top: .6rem;
        margin-top: .6rem;
    }

    .pastille-statut {
        border-radius: 12px;
        padding: .18rem .5rem;
        font-size: .72rem;
        font-weight: 600;
    }

    .statut-attente { background: #fff3d6; color: #8f6300; }
    .statut-revision { background: #e5ebff; color: #2d4bb3; }
    .statut-approuve { background: #dff5e3; color: #207a38; }

    .adoption-miniature {
        display: grid;
        grid-template-columns: 78px 1fr;
        gap: .75rem;
        align-items: center;
    }

    .adoption-miniature img {
        width: 78px;
        height: 78px;
        border-radius: 10px;
        object-fit: cover;
    }

    .actions-aide .btn {
        border-radius: 10px;
        text-align: left;
    }

    .banniere-impact {
        border: 1px solid #e4e8e3;
        border-radius: 14px;
        background: linear-gradient(180deg, #f8faf7 0%, #f1f5ef 100%);
        padding: 1rem;
    }

    .grille-impact {
        display: grid;
        grid-template-columns: 220px repeat(4, minmax(0, 1fr));
        gap: 1rem;
        align-items: center;
    }

    .illustration-impact {
        width: 100%;
        height: 120px;
        border-radius: 10px;
        object-fit: cover;
    }

    .colonne-impact strong { display: block; font-size: .92rem; }
    .colonne-impact small { color: #6b7280; }

    .bascule-animaux {
        display: inline-flex;
        gap: .35rem;
        flex-wrap: wrap;
    }

    .bascule-animaux .btn {
        border-radius: 999px;
        padding: .28rem .75rem;
        font-size: .78rem;
    }

    @media (max-width: 1199px) {
        .illustration-heros { max-width: 38%; }
        .grille-impact { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 991px) {
        .illustration-heros { display: none; }
        .titre-tableau { font-size: 1.7rem; }
        .grille-impact { grid-template-columns: 1fr; }
    }
</style>

<div class="client-coquille">
    <section class="client-banniere mb-4">
        <img class="illustration-heros" src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=900&auto=format&fit=crop" alt="Animaux">
        <div class="row g-3 align-items-end">
            <div class="col-lg-8">
                <div class="titre-tableau">Bonjour {{ auth()->user()->nom }} !</div>
                <p class="text-muted mb-3">Ensemble, offrons-leur une nouvelle vie.</p>

                <form method="GET" action="{{ route('animals.index') }}" class="row g-2 recherche-rapide">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher un animal (nom, espece, race)">
                    </div>
                    <div class="col-md-2">
                        <select name="espece" class="form-select">
                            <option value="">Espece</option>
                            <option value="Chien">Chien</option>
                            <option value="Chat">Chat</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="age_max" class="form-select">
                            <option value="">Age</option>
                            <option value="1">1 an</option>
                            <option value="3">3 ans</option>
                            <option value="5">5 ans</option>
                            <option value="10">10 ans+</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">Rechercher</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="row g-2">
                    <div class="col-12">
                        <div class="carte-mini-stats">
                            <div class="text-muted">Animaux disponibles</div>
                            <div class="h4 mb-0">{{ $stats['animaux_disponibles'] }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="carte-mini-stats">
                            <div class="text-muted">Mes demandes</div>
                            <div class="h4 mb-0">{{ $stats['demandes_total'] }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="carte-mini-stats">
                            <div class="text-muted">En attente</div>
                            <div class="h4 mb-0">{{ $stats['demandes_en_attente'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mb-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h4 class="mb-0">Animaux a adopter</h4>
            <span class="badge text-bg-light">Favoris: {{ $stats['favoris_total'] ?? 0 }}</span>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="bascule-animaux" role="group" aria-label="Filtre des animaux dashboard">
                <a href="{{ route('dashboard', ['vue_animaux' => 'tous']) }}" class="btn {{ $afficherFavoris ? 'btn-outline-secondary' : 'btn-success' }} btn-sm">Tous</a>
                <a href="{{ route('dashboard', ['vue_animaux' => 'favoris']) }}" class="btn {{ $afficherFavoris ? 'btn-success' : 'btn-outline-secondary' }} btn-sm">Mes favoris</a>
            </div>
            <a href="{{ route('animals.index', ['favoris_only' => 1]) }}" class="small text-decoration-none">Voir mes favoris dans le catalogue</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @forelse($featuredAnimals as $animal)
            @php
                $imageChienSecours = 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?q=80&w=640&auto=format&fit=crop';
                $imageChatSecours = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=640&auto=format&fit=crop';
                $imageSecours = strtolower((string) $animal->espece) === 'chat' ? $imageChatSecours : $imageChienSecours;
                $urlImage = $animal->chemin_image ? \Illuminate\Support\Facades\Storage::url($animal->chemin_image) : $imageSecours;
                $estFavori = ($idsAnimauxFavoris ?? collect())->contains($animal->id);
            @endphp
            <div class="col-md-4 col-lg">
                <div class="carte-animal-mini">
                    <div class="couverture-animal-mini">
                        <img src="{{ $urlImage }}" alt="{{ $animal->nom }}">
                        <span class="badge-animal-mini">Nouveau</span>
                        <span class="bouton-favori-mini">{{ $estFavori ? '♥' : '♡' }}</span>
                    </div>
                    <div class="corps-animal-mini">
                        <div class="fw-semibold">{{ $animal->nom }}</div>
                        <div class="meta-animal-mini">{{ $animal->espece }} · {{ $animal->age ?? '?' }} ans · {{ $animal->genre }}</div>
                        <div class="lieu-animal-mini">{{ $animal->localisation ?? 'Localisation non precisee' }}</div>
                        <a href="{{ route('animals.show', $animal) }}" class="btn btn-sm btn-outline-primary mt-2">Voir</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">
                    @if($afficherFavoris)
                        Aucun favori disponible pour le moment. Ajoutez des favoris depuis la page animaux.
                    @else
                        Aucun animal disponible pour le moment.
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @php
        $adopted = $recentRequests->firstWhere('statut', 'approuve');
        $adoptionAnimal = $adopted?->animal;
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-lg-5">
            <div class="panneau-section">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="titre-section">Mes demandes d'adoption</div>
                    <a href="{{ route('payments.index') }}" class="small text-decoration-none">Mes paiements</a>
                </div>

                @if($recentRequests->isEmpty())
                    <div class="alert alert-info mt-3 mb-0">Aucune demande pour le moment.</div>
                @else
                    @foreach($recentRequests as $demande)
                        <div class="element-demande">
                            <div class="d-flex justify-content-between gap-2 align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $demande->animal->nom ?? 'Animal' }}</div>
                                    <div class="small text-muted">Demande envoyee le {{ $demande->created_at?->format('d/m/Y') }}</div>
                                </div>
                                @if($demande->statut === 'approuve')
                                    <span class="pastille-statut statut-approuve">Approuvee</span>
                                @elseif($demande->statut === 'en_revision')
                                    <span class="pastille-statut statut-revision">En revision</span>
                                @else
                                    <span class="pastille-statut statut-attente">En attente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panneau-section">
                <div class="titre-section mb-3">Mon adoption</div>
                @if($adoptionAnimal)
                    @php
                        $imageChienSecours = 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?q=80&w=420&auto=format&fit=crop';
                        $imageChatSecours = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=420&auto=format&fit=crop';
                        $imageSecoursAdoption = strtolower((string) $adoptionAnimal->espece) === 'chat' ? $imageChatSecours : $imageChienSecours;
                        $imageAdoption = $adoptionAnimal->chemin_image ? \Illuminate\Support\Facades\Storage::url($adoptionAnimal->chemin_image) : $imageSecoursAdoption;
                    @endphp
                    <div class="adoption-miniature">
                        <img src="{{ $imageAdoption }}" alt="{{ $adoptionAnimal->nom }}">
                        <div>
                            <div class="fw-semibold">{{ $adoptionAnimal->nom }}</div>
                            <div class="small text-muted">{{ $adoptionAnimal->espece }} · {{ $adoptionAnimal->age ?? '?' }} ans</div>
                            <div class="small text-muted">Adopte le {{ $adopted->updated_at?->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <a href="{{ route('animals.show', $adoptionAnimal) }}" class="btn btn-sm btn-outline-success mt-3">Voir le suivi post-adoption</a>
                @else
                    <p class="small text-muted mb-3">Aucune adoption validee pour le moment.</p>
                    <a href="{{ route('animals.index') }}" class="btn btn-sm btn-outline-success">Voir les animaux disponibles</a>
                @endif
            </div>
        </div>

        <div class="col-lg-3">
            <div class="panneau-section">
                <div class="titre-section mb-3">Besoin d'aide ?</div>
                <p class="small text-muted">Consultez notre FAQ ou contactez notre equipe.</p>
                <div class="actions-aide d-grid gap-2 mt-3">
                    <a href="{{ route('notifications.index') }}" class="btn btn-light btn-sm border">Voir la FAQ</a>
                    <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm border">Nous contacter</a>
                </div>
            </div>
        </div>
    </div>

    <section class="banniere-impact mb-2">
        <div class="grille-impact">
            <div>
                <img class="illustration-impact" src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=640&auto=format&fit=crop" alt="Adoption responsable">
                <div class="mt-2">
                    <strong>Chaque adoption change une vie.</strong>
                    <small>Merci de donner une seconde chance a nos compagnons.</small>
                </div>
            </div>
            <div class="colonne-impact">
                <strong>Adoption responsable</strong>
                <small>Nous vous accompagnons a chaque etape.</small>
            </div>
            <div class="colonne-impact">
                <strong>Suivi personnalise</strong>
                <small>Un suivi apres adoption pour leur bien-etre.</small>
            </div>
            <div class="colonne-impact">
                <strong>Communaute bienveillante</strong>
                <small>Rejoignez une communaute de passionnes.</small>
            </div>
            <div class="colonne-impact">
                <strong>Services utiles</strong>
                <small>Paiements, notifications et profil reunis.</small>
            </div>
        </div>
    </section>

    <div class="mt-3">
        {{ $requests->links() }}
    </div>
</div>
@endsection
