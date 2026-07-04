@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .navbar {
        display: none !important;
    }

    .container.py-4 {
        max-width: 100% !important;
        padding-top: 0.75rem !important;
    }

    .espace-admin {
        --bleu-principal: #1f4bd8;
        --bleu-nuit: #0d1c3d;
        --fond-page: #f3f6fb;
        --fond-carte: #ffffff;
        --texte-fort: #172037;
        --texte-secondaire: #6d7990;
        background: radial-gradient(circle at 0% 0%, #eaf0ff, #f3f6fb 35%), radial-gradient(circle at 100% 100%, #eef8ff, #f3f6fb 45%);
        border: 1px solid #dfe7f6;
        border-radius: 20px;
        padding: 1rem;
        color: var(--texte-fort);
    }

    .grille-admin {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 1rem;
    }

    .panneau-admin {
        background: linear-gradient(165deg, #0f234d 0%, #081329 100%);
        border-radius: 16px;
        color: #e9f0ff;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .entete-marque {
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        padding-bottom: 0.9rem;
        margin-bottom: 1rem;
    }

    .titre-marque {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .sous-titre-marque {
        margin: 0;
        font-size: 0.85rem;
        opacity: 0.85;
    }

    .groupe-lien {
        margin-bottom: 1rem;
    }

    .libelle-groupe {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #a9bbea;
        margin-bottom: 0.45rem;
    }

    .lien-admin {
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: #e9f0ff;
        padding: 0.6rem 0.75rem;
        border-radius: 10px;
        margin-bottom: 0.35rem;
        font-size: 0.93rem;
        transition: background-color .2s ease, transform .2s ease;
    }

    .lien-admin.groupe {
        gap: 0.55rem;
        justify-content: flex-start;
    }

    .lien-admin .icone {
        width: 1rem;
        text-align: center;
        opacity: 0.92;
        font-size: 0.9rem;
    }

    .point-actif-lien {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.9);
    }

    .texte-lien {
        flex: 1;
    }

    .badge-navigation {
        background: #ff4d6d;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        border-radius: 999px;
        min-width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.35rem;
    }

    .badge-navigation.neutre {
        background: rgba(255, 255, 255, 0.16);
        color: #c9d6f4;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 8px;
        height: auto;
        min-width: auto;
        padding: 0.05rem 0.35rem;
    }

    .lien-admin:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        transform: translateX(2px);
    }

    .lien-admin.actif {
        background: linear-gradient(135deg, #3865ff, #274bd0);
        color: #fff;
        box-shadow: 0 8px 16px rgba(39, 75, 208, 0.32);
    }

    .action-deconnexion {
        margin-top: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        padding-top: 0.9rem;
    }

    .contenu-admin {
        background: rgba(255, 255, 255, 0.66);
        border-radius: 16px;
        padding: 1rem;
    }

    .barre-superieure {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .btn-panneau-mobile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 38px;
        border: 1px solid #d4def2;
        background: #fff;
        border-radius: 10px;
        padding: 0;
        color: #2f3d62;
    }

    .btn-panneau-mobile i {
        font-size: 1.1rem;
        line-height: 1;
    }

    .champ-recherche-admin {
        flex: 1;
        max-width: 860px;
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #dbe4f5;
        border-radius: 12px;
        padding: 0.35rem 0.7rem;
    }

    .icone-recherche {
        color: #8391af;
        font-size: 0.92rem;
        line-height: 1;
    }

    .champ-recherche-admin input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 0.92rem;
    }

    .filtre-periode {
        border: 1px solid #dbe4f5;
        border-radius: 10px;
        background: #fff;
        padding: 0.35rem 0.55rem;
        font-size: 0.9rem;
    }

    .zone-outils-admin {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }

    .bouton-notification-admin {
        position: relative;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid #dbe4f5;
        background: #fff;
        color: #2e3a5f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .bouton-notification-admin i {
        font-size: 1rem;
    }

    .badge-notification-haut {
        position: absolute;
        top: -7px;
        right: -6px;
        min-width: 18px;
        height: 18px;
        border-radius: 999px;
        background: #ff4d6d;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.3rem;
    }

    .avatar-admin-mini {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3562ef, #1f4bd8);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .avatar-admin-mini img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .carte-identite-admin {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        border: 1px solid #dbe4f5;
        border-radius: 10px;
        background: #fff;
        padding: 0.28rem 0.5rem;
        color: #1f2d51;
        text-decoration: none;
    }

    .carte-identite-admin:hover {
        color: #16213f;
        border-color: #cbd7f1;
    }

    .identite-admin-texte {
        display: grid;
        line-height: 1.1;
    }

    .identite-admin-texte strong {
        font-size: 0.78rem;
        max-width: 138px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .identite-admin-texte span {
        font-size: 0.71rem;
        color: #6f7c98;
    }

    .en-tete-admin {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .titre-page-admin {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 700;
    }

    .sous-titre-page-admin {
        color: var(--texte-secondaire);
        margin: 0.25rem 0 0;
    }

    .grille-kpis {
        display: grid;
        grid-template-columns: repeat(4, minmax(140px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .carte-kpi {
        background: var(--fond-carte);
        border: 1px solid #dbe4f5;
        border-radius: 14px;
        padding: 0.9rem;
        box-shadow: 0 8px 20px rgba(27, 45, 96, 0.05);
    }

    .kpi-haut {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.4rem;
    }

    .kpi-valeur {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 700;
        line-height: 1;
    }

    .kpi-libelle {
        margin: 0;
        font-size: 0.9rem;
        color: var(--texte-secondaire);
    }

    .icone-kpi {
        color: #4d5f87;
        opacity: 0.88;
        font-size: 1rem;
    }

    .kpi-evolution {
        margin-top: 0.35rem;
        font-size: 0.8rem;
        color: #1f8b4d;
        font-weight: 600;
    }

    .kpi-evolution.neutre {
        color: #7a859f;
    }

    .grille-haute {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        align-items: start;
    }

    .grille-basse {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        align-items: start;
    }

    .carte-admin {
        background: var(--fond-carte);
        border: 1px solid #dbe4f5;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(27, 45, 96, 0.05);
        display: flex;
        flex-direction: column;
    }

    .entete-carte-admin {
        padding: 0.8rem 0.95rem;
        border-bottom: 1px solid #edf2fb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 0 0 auto;
    }

    .titre-carte-admin {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .corps-carte-admin {
        padding: 0.72rem;
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
        overflow: hidden;
    }

    .hauteur-carte-haute {
        height: 300px;
    }

    .hauteur-carte-basse {
        height: 320px;
    }

    .hauteur-carte-activite {
        height: 300px;
    }

    .hauteur-carte-utilisateurs {
        height: 360px;
    }

    .tableau-admin {
        width: 100%;
        border-collapse: collapse;
    }

    .tableau-admin th,
    .tableau-admin td {
        font-size: 0.86rem;
        padding: 0.38rem 0.45rem;
        border-bottom: 1px solid #edf2fb;
        vertical-align: middle;
    }

    .tableau-admin th {
        color: #71809f;
        font-weight: 600;
    }

    .pastille-statut {
        border-radius: 999px;
        padding: 0.2rem 0.62rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.015em;
        border: 1px solid transparent;
    }

    .pastille-attente { background: #f7f0de; color: #8b6a1f; border-color: #eadbb7; }
    .pastille-approuve { background: #e7f3eb; color: #2f6f4f; border-color: #cfe3d5; }
    .pastille-rejete { background: #f8e8eb; color: #8d3c4a; border-color: #eccfd6; }
    .pastille-actif { background: #e7f3eb; color: #2f6f4f; border-color: #cfe3d5; }
    .pastille-inactif { background: #edf1f6; color: #5f6d83; border-color: #d9e0ea; }
    .pastille-role { background: #eef3fb; color: #385178; border-color: #d8e2f0; text-transform: uppercase; }
    .pastille-role-admin { background: #edeaff; color: #5340a8; border-color: #dad2ff; }
    .pastille-role-manager { background: #e7f3eb; color: #2f6f4f; border-color: #cfe3d5; }
    .pastille-role-client { background: #f2f4f8; color: #4f5d73; border-color: #dde3ed; }

    .liste-activite {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .ligne-activite {
        padding: 0.6rem 0;
        border-bottom: 1px solid #edf2fb;
    }

    .ligne-activite:last-child {
        border-bottom: none;
    }

    .ligne-activite small {
        color: #7b87a1;
        display: block;
        margin-bottom: 0.2rem;
    }

    .zone-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-bottom: 0.9rem;
    }

    .table-utilisateurs .actions {
        display: flex;
        gap: 0.35rem;
        flex-wrap: wrap;
    }

    .scroll-table {
        overflow-x: auto;
    }

    .point-couleur {
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        margin-right: 0.35rem;
        flex: 0 0 auto;
    }

    .legende-especes {
        margin: 0;
        padding: 0 0.15rem 0 0;
        list-style: none;
        font-size: 0.84rem;
        color: #62708f;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 0.4rem 0.55rem;
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
        align-content: start;
        scrollbar-gutter: stable;
    }

    .legende-especes li {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        min-width: 0;
        background: #f8fbff;
        border: 1px solid #e5eefb;
        border-radius: 10px;
        padding: 0.35rem 0.55rem;
        line-height: 1.2;
    }

    .legende-especes .libelle-espece {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1 1 auto;
    }

    .legende-especes .valeur-espece {
        flex: 0 0 auto;
        color: #1f2e4a;
        font-weight: 700;
    }

    .zone-graphique-grande {
        position: relative;
        height: 185px;
    }

    .zone-graphique-moyenne {
        position: relative;
        height: 138px;
        flex: 0 0 auto;
    }

    .zone-graphique-grande canvas,
    .zone-graphique-moyenne canvas {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .corps-liste-compacte {
        max-height: 100%;
        overflow-y: auto;
    }

    .corps-activite-compacte {
        max-height: 100%;
        overflow-y: auto;
    }

    .corps-table-utilisateurs {
        max-height: 100%;
        overflow-y: auto;
    }

    @media (max-width: 1200px) {
        .grille-kpis {
            grid-template-columns: repeat(2, minmax(140px, 1fr));
        }

        .grille-haute {
            grid-template-columns: 1fr;
        }

        .grille-basse {
            grid-template-columns: 1fr;
        }

        .hauteur-carte-haute,
        .hauteur-carte-basse,
        .hauteur-carte-activite,
        .hauteur-carte-utilisateurs {
            height: auto;
        }

        .zone-graphique-grande,
        .zone-graphique-moyenne {
            height: 210px;
        }
    }

    @media (max-width: 992px) {
        .grille-admin {
            grid-template-columns: 1fr;
        }

        .panneau-admin {
            display: none;
        }

        .panneau-admin.ouvert {
            display: flex;
        }
    }

    @media (max-width: 640px) {
        .grille-kpis {
            grid-template-columns: 1fr;
        }

        .barre-superieure {
            flex-wrap: wrap;
        }

        .zone-outils-admin {
            margin-left: 0;
            width: 100%;
            justify-content: space-between;
        }

        .carte-identite-admin {
            min-width: 0;
        }

        .identite-admin-texte strong {
            max-width: 92px;
        }

        .filtre-periode {
            width: 100%;
        }
    }
</style>

@php
    $notificationsNonLues = auth()->user()?->unreadNotifications()->count() ?? 0;
    $utilisateurConnecte = auth()->user();
    $photoProfil = $utilisateurConnecte?->profile_photo_path
        ? \Illuminate\Support\Facades\Storage::url($utilisateurConnecte->profile_photo_path)
        : null;
    $libelleRole = match ($utilisateurConnecte?->role) {
        'admin' => 'Administrateur',
        'manager' => 'Gestionnaire',
        default => 'Utilisateur',
    };
    $initialesAdmin = collect(explode(' ', trim($utilisateurConnecte?->nom ?? 'Admin')))
        ->filter()
        ->take(2)
        ->map(fn ($partie) => mb_strtoupper(mb_substr($partie, 0, 1)))
        ->join('');
@endphp

<div class="espace-admin">
    <div class="grille-admin">
        <aside class="panneau-admin" id="panneau-admin">
            <div class="entete-marque">
                <p class="titre-marque">Adopte un ami</p>
                <p class="sous-titre-marque">Panneau d'administration</p>
            </div>

            <div class="groupe-lien">
                <div class="libelle-groupe">Tableau</div>
                <a class="lien-admin groupe actif" href="{{ route('admin.dashboard') }}">
                    <i class="icone bi bi-house-door"></i>
                    <span class="texte-lien">Tableau de bord</span>
                    <span class="point-actif-lien" aria-hidden="true"></span>
                </a>
            </div>

            <div class="groupe-lien">
                <div class="libelle-groupe">Gestion</div>
                <a class="lien-admin groupe" href="{{ route('animals.index') }}">
                    <i class="icone bi bi-grid"></i>
                    <span class="texte-lien">Animaux</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('adoptions.index') }}">
                    <i class="icone bi bi-file-earmark-text"></i>
                    <span class="texte-lien">Demandes d'adoption</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.adoptants.index') }}">
                    <i class="icone bi bi-people"></i>
                    <span class="texte-lien">Adoptants</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.payments.index') }}">
                    <i class="icone bi bi-credit-card-2-front"></i>
                    <span class="texte-lien">Paiements</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.suivi.index') }}">
                    <i class="icone bi bi-graph-up-arrow"></i>
                    <span class="texte-lien">Suivi post-adoption</span>
                </a>
            </div>

            <div class="groupe-lien">
                <div class="libelle-groupe">Contenu</div>
                <a class="lien-admin groupe" href="{{ route('admin.contenu.articles') }}">
                    <i class="icone bi bi-journal-richtext"></i>
                    <span class="texte-lien">Articles / Conseils</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.contenu.pages') }}">
                    <i class="icone bi bi-file-earmark"></i>
                    <span class="texte-lien">Pages</span>
                </a>
            </div>

            <div class="groupe-lien">
                <div class="libelle-groupe">Communication</div>
                <a class="lien-admin groupe" href="{{ route('notifications.index') }}">
                    <i class="icone bi bi-bell"></i>
                    <span class="texte-lien">Notifications</span>
                    @if($notificationsNonLues > 0)
                        <span class="badge-navigation">{{ $notificationsNonLues > 99 ? '99+' : $notificationsNonLues }}</span>
                    @endif
                </a>
            </div>

            <div class="groupe-lien">
                <div class="libelle-groupe">Paramètres</div>
                <a class="lien-admin groupe" href="{{ route('admin.users.index') }}">
                    <i class="icone bi bi-people-fill"></i>
                    <span class="texte-lien">Utilisateurs</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.roles.index') }}">
                    <i class="icone bi bi-shield-lock"></i>
                    <span class="texte-lien">Rôles et permissions</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.pricing.index') }}">
                    <i class="icone bi bi-cash-coin"></i>
                    <span class="texte-lien">Fixer paiement</span>
                </a>
                <a class="lien-admin groupe" href="{{ route('admin.settings.index') }}">
                    <i class="icone bi bi-gear"></i>
                    <span class="texte-lien">Paramètres</span>
                </a>
            </div>

            <div class="action-deconnexion">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">Déconnexion</button>
                </form>
            </div>
        </aside>

        <section class="contenu-admin">
            <div class="barre-superieure">
                <button class="btn-panneau-mobile" type="button" id="btn-panneau-mobile" aria-label="Afficher le menu">
                    <i class="bi bi-list"></i>
                </button>
                <form method="GET" action="{{ route('animals.index') }}" class="champ-recherche-admin">
                    <i class="bi bi-search me-2 icone-recherche"></i>
                    <input type="text" name="search" placeholder="Rechercher (animaux, demandes, adoptants...)" />
                </form>
                <div class="zone-outils-admin">
                    <a href="{{ route('notifications.index') }}" class="bouton-notification-admin" title="Notifications">
                        <i class="bi bi-bell-fill"></i>
                        @if($notificationsNonLues > 0)
                            <span class="badge-notification-haut">{{ $notificationsNonLues > 99 ? '99+' : $notificationsNonLues }}</span>
                        @endif
                    </a>

                    <a href="{{ route('profile.show') }}" class="carte-identite-admin" title="Mon profil">
                        <span class="avatar-admin-mini">
                            @if($photoProfil)
                                <img src="{{ $photoProfil }}" alt="Photo de profil de {{ $utilisateurConnecte->nom ?? 'Administrateur' }}">
                            @else
                                {{ $initialesAdmin !== '' ? $initialesAdmin : 'A' }}
                            @endif
                        </span>
                        <span class="identite-admin-texte">
                            <strong>{{ $utilisateurConnecte->nom ?? 'Administrateur' }}</strong>
                            <span>{{ $libelleRole }}</span>
                        </span>
                    </a>

                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <select class="filtre-periode" name="periode" onchange="this.form.submit()">
                            <option value="7j" @selected($periode === '7j')>7 jours</option>
                            <option value="30j" @selected($periode !== '7j' && $periode !== '90j')>30 jours</option>
                            <option value="90j" @selected($periode === '90j')>90 jours</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="en-tete-admin">
                <div>
                    <h2 class="titre-page-admin">Tableau de bord administrateur</h2>
                    <p class="sous-titre-page-admin">Vue globale de l'activité de votre plateforme d'adoption.</p>
                </div>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-dark btn-sm">Consulter les logs</a>
            </div>

            <div class="grille-kpis">
                <article class="carte-kpi">
                    <div class="kpi-haut">
                        <p class="kpi-libelle">Utilisateurs</p>
                        <i class="bi bi-people-fill icone-kpi"></i>
                    </div>
                    <p class="kpi-valeur">{{ $stats['users'] }}</p>
                    <p class="kpi-evolution">+{{ $stats['users_this_month'] }} ce mois</p>
                </article>

                <article class="carte-kpi">
                    <div class="kpi-haut">
                        <p class="kpi-libelle">Demandes</p>
                        <i class="bi bi-file-earmark-text-fill icone-kpi"></i>
                    </div>
                    <p class="kpi-valeur">{{ $stats['requests'] }}</p>
                    <p class="kpi-evolution">+{{ $stats['requests_this_month'] }} ce mois</p>
                </article>

                <article class="carte-kpi">
                    <div class="kpi-haut">
                        <p class="kpi-libelle">Adoptants</p>
                        <i class="bi bi-person-check-fill icone-kpi"></i>
                    </div>
                    <p class="kpi-valeur">{{ $stats['adopters'] }}</p>
                    <p class="kpi-evolution neutre">{{ $stats['active_users'] }} comptes actifs</p>
                </article>

                <article class="carte-kpi">
                    <div class="kpi-haut">
                        <p class="kpi-libelle">Adoptions ce mois</p>
                        <i class="bi bi-heart-fill icone-kpi"></i>
                    </div>
                    <p class="kpi-valeur">{{ $stats['adoptions_this_month'] }}</p>
                    <p class="kpi-evolution neutre">{{ $stats['pending'] }} en attente</p>
                </article>
            </div>

            <div class="grille-haute">
                <article class="carte-admin hauteur-carte-haute">
                    <div class="entete-carte-admin">
                        <h3 class="titre-carte-admin">Demandes d'adoption récentes</h3>
                        <a href="{{ route('adoptions.index') }}" class="small">Voir toutes</a>
                    </div>
                    <div class="corps-carte-admin scroll-table corps-liste-compacte">
                        <table class="tableau-admin">
                            <thead>
                                <tr>
                                    <th>Adoptant</th>
                                    <th>Animal</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRequests as $demande)
                                    @php
                                        $classeStatut = match ($demande->statut) {
                                            'approuve' => 'pastille-approuve',
                                            'rejete' => 'pastille-rejete',
                                            default => 'pastille-attente',
                                        };
                                        $libelleStatut = match ($demande->statut) {
                                            'approuve' => 'Approuvée',
                                            'rejete' => 'Refusée',
                                            default => 'En attente',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $demande->utilisateur->nom ?? 'Utilisateur' }}</td>
                                        <td>{{ $demande->animal->nom ?? 'Animal' }}</td>
                                        <td><span class="pastille-statut {{ $classeStatut }}">{{ $libelleStatut }}</span></td>
                                        <td>{{ $demande->created_at?->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">Aucune demande récente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="carte-admin hauteur-carte-haute">
                    <div class="entete-carte-admin">
                        <h3 class="titre-carte-admin">Statistiques</h3>
                    </div>
                    <div class="corps-carte-admin">
                        <div class="zone-graphique-grande">
                            <canvas id="courbeDemandesChart"></canvas>
                        </div>
                    </div>
                </article>
            </div>

            <div class="grille-basse">
                <article class="carte-admin hauteur-carte-basse">
                    <div class="entete-carte-admin">
                        <h3 class="titre-carte-admin">Répartition des animaux</h3>
                    </div>
                    <div class="corps-carte-admin">
                        <div class="zone-graphique-moyenne">
                            <canvas id="especesChart"></canvas>
                        </div>
                        <ul class="legende-especes" id="legende-especes"></ul>
                    </div>
                </article>

                <article class="carte-admin hauteur-carte-basse">
                    <div class="entete-carte-admin">
                        <h3 class="titre-carte-admin">Adoptions par mois</h3>
                    </div>
                    <div class="corps-carte-admin">
                        <div class="zone-graphique-moyenne">
                            <canvas id="adoptionsMoisChart"></canvas>
                        </div>
                    </div>
                </article>

                <article class="carte-admin hauteur-carte-activite">
                    <div class="entete-carte-admin">
                        <h3 class="titre-carte-admin">Activité récente</h3>
                        <a href="{{ route('admin.logs.index') }}" class="small">Voir tout</a>
                    </div>
                    <div class="corps-carte-admin corps-activite-compacte">
                        <ul class="liste-activite">
                            @forelse($logs->take(5) as $log)
                                <li class="ligne-activite">
                                    <small>{{ $log->created_at?->format('d/m/Y H:i') }}</small>
                                    <div><strong>{{ $log->user->nom ?? 'Système' }}:</strong> {{ $log->description ?? $log->action }}</div>
                                </li>
                            @empty
                                <li class="text-muted">Aucune activité récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </article>
            </div>

            <article class="carte-admin hauteur-carte-utilisateurs mt-3" id="bloc-utilisateurs">
                <div class="entete-carte-admin">
                    <h3 class="titre-carte-admin">Gestion des utilisateurs</h3>
                </div>
                <div class="corps-carte-admin">
                    <div class="zone-actions">
                        <a href="{{ route('animals.index') }}" class="btn btn-sm btn-outline-success">Catalogue animaux</a>
                        <a href="{{ route('animals.create') }}" class="btn btn-sm btn-success">Ajouter un animal</a>
                        <a href="{{ route('adoptions.index') }}" class="btn btn-sm btn-outline-primary">Gérer les demandes</a>
                    </div>

                    <div class="scroll-table table-utilisateurs corps-table-utilisateurs">
                        <table class="tableau-admin">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    @php
                                        $classeRole = match ($user->role) {
                                            'admin' => 'pastille-role-admin',
                                            'manager' => 'pastille-role-manager',
                                            default => 'pastille-role-client',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $user->nom }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="pastille-statut pastille-role {{ $classeRole }}">{{ $user->role }}</span></td>
                                        <td>
                                            @if($user->actif)
                                                <span class="pastille-statut pastille-actif">Actif</span>
                                            @else
                                                <span class="pastille-statut pastille-inactif">Inactif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $user->actif ? 'Désactiver' : 'Activer' }}</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted">Aucun utilisateur à afficher.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pt-2">
                        {{ $users->links() }}
                    </div>
                </div>
            </article>
        </section>
    </div>
</div>

<div id="admin-charts-data" data-chart='@json($chartData)'></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const donneesBrutes = document.getElementById('admin-charts-data')?.dataset.chart;
    const donneesGraphiques = donneesBrutes
        ? JSON.parse(donneesBrutes)
        : {
            courbeDemandes: { labels: [], demandes: [], adoptions: [] },
            adoptionsMensuelles: { labels: [], values: [] },
            repartitionEspeces: { labels: [], values: [] },
        };

    const couleursEspeces = ['#4f7cff', '#4faf77', '#f29f46', '#7f65d6', '#24a5d8'];

    function initialiserGraphiquesAdmin() {
        if (!window.Chart) {
            return;
        }

        const optionsPerformance = {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            normalized: true,
        };

        const canevasCourbe = document.getElementById('courbeDemandesChart');
        const canevasMois = document.getElementById('adoptionsMoisChart');
        const canevasEspeces = document.getElementById('especesChart');

        if (canevasCourbe) {
            new window.Chart(canevasCourbe, {
            type: 'line',
            data: {
                labels: donneesGraphiques.courbeDemandes.labels,
                datasets: [
                    {
                        label: 'Demandes',
                        data: donneesGraphiques.courbeDemandes.demandes,
                        borderColor: '#3e66f3',
                        backgroundColor: 'rgba(62, 102, 243, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 2,
                        pointHoverRadius: 3,
                        parsing: false
                    },
                    {
                        label: 'Adoptions',
                        data: donneesGraphiques.courbeDemandes.adoptions,
                        borderColor: '#3ea15f',
                        backgroundColor: 'rgba(62, 161, 95, 0.08)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 2,
                        pointHoverRadius: 3,
                        parsing: false
                    }
                ]
            },
            options: {
                ...optionsPerformance,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 8 } }
                }
            }
        });
        }

        if (canevasMois) {
            new window.Chart(canevasMois, {
            type: 'bar',
            data: {
                labels: donneesGraphiques.adoptionsMensuelles.labels,
                datasets: [{
                    label: 'Adoptions',
                    data: donneesGraphiques.adoptionsMensuelles.values,
                    backgroundColor: '#77b85f',
                    borderRadius: 8,
                    parsing: false
                }]
            },
            options: {
                ...optionsPerformance,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        }

        if (canevasEspeces) {
            new window.Chart(canevasEspeces, {
            type: 'doughnut',
            data: {
                labels: donneesGraphiques.repartitionEspeces.labels,
                datasets: [{
                    data: donneesGraphiques.repartitionEspeces.values,
                    backgroundColor: couleursEspeces,
                    borderWidth: 0,
                    parsing: false
                }]
            },
            options: {
                ...optionsPerformance,
                cutout: '68%',
                plugins: { legend: { display: false } }
            }
        });
        }

        const legendeEspeces = document.getElementById('legende-especes');
        if (legendeEspeces) {
            legendeEspeces.innerHTML = '';
            donneesGraphiques.repartitionEspeces.labels.forEach((libelle, index) => {
                const valeur = donneesGraphiques.repartitionEspeces.values[index] ?? 0;
                const ligne = document.createElement('li');

                const point = document.createElement('span');
                point.className = 'point-couleur';
                point.style.background = couleursEspeces[index % couleursEspeces.length];

                const etiquette = document.createElement('span');
                etiquette.className = 'libelle-espece';
                etiquette.textContent = libelle;
                etiquette.title = libelle;

                const compteur = document.createElement('strong');
                compteur.className = 'valeur-espece';
                compteur.textContent = `(${valeur})`;

                ligne.append(point, etiquette, compteur);
                legendeEspeces.appendChild(ligne);
            });
        }
    }

    if ('requestIdleCallback' in window) {
        window.requestIdleCallback(initialiserGraphiquesAdmin, { timeout: 800 });
    } else {
        window.setTimeout(initialiserGraphiquesAdmin, 0);
    }

    const btnPanneau = document.getElementById('btn-panneau-mobile');
    const panneauAdmin = document.getElementById('panneau-admin');
    if (btnPanneau && panneauAdmin) {
        btnPanneau.addEventListener('click', () => {
            panneauAdmin.classList.toggle('ouvert');
        });
    }
</script>
@endsection
