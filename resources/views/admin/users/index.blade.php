@extends('layouts.app')

@section('content')
<style>
    .page-admin {
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
        grid-template-columns: repeat(3, minmax(0, 1fr));
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

    .grille-sections {
        display: grid;
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

    .badge-role,
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

    .badge-admin { background: #eef3ff; border-color: #d8e1ff; color: #3459c8; }
    .badge-manager { background: #edf7f2; border-color: #d2eadf; color: #2d7a55; }
    .badge-client { background: #f8f5ea; border-color: #e7ddbc; color: #8a6a1b; }
    .badge-actif { background: #edf7f2; border-color: #d2eadf; color: #2d7a55; }
    .badge-inactif { background: #f8f5ea; border-color: #e7ddbc; color: #8a6a1b; }

    .profil-mini {
        display: flex;
        gap: 0.65rem;
        align-items: center;
    }

    .avatar-mini {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2f5ad9, #2143a2);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-weight: 800;
        flex-shrink: 0;
    }

    .avatar-mini img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .infos p {
        margin: 0;
        color: #5a6c8d;
        font-size: 0.86rem;
    }

    .actions-ligne {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .section-role {
        border-top: 1px solid #edf2f8;
        padding: 0.25rem 0 0;
    }

    @media (max-width: 1100px) {
        .grille-kpi {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-admin">
    <div class="entete-page">
        <h2>Utilisateurs</h2>
        <p>Gestion séparée des clients, administrateurs et gestionnaires avec activation, édition et suppression.</p>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi">
            <p class="libelle">Clients</p>
            <p class="valeur">{{ $compteurs['client'] ?? 0 }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Gestionnaires</p>
            <p class="valeur">{{ $compteurs['manager'] ?? 0 }}</p>
        </div>
        <div class="carte-kpi">
            <p class="libelle">Administrateurs</p>
            <p class="valeur">{{ $compteurs['admin'] ?? 0 }}</p>
        </div>
    </div>

    @foreach([
        'client' => ['label' => 'Clients', 'badge' => 'badge-client', 'items' => $clients],
        'manager' => ['label' => 'Gestionnaires', 'badge' => 'badge-manager', 'items' => $gestionnaires],
        'admin' => ['label' => 'Administrateurs', 'badge' => 'badge-admin', 'items' => $administrateurs],
    ] as $roleKey => $blocRole)
        <section class="bloc mb-3">
            <div class="bloc-entete">
                <h3>{{ $blocRole['label'] }}</h3>
                <span class="badge-role {{ $blocRole['badge'] }}">{{ $blocRole['items']->total() }} compte(s)</span>
            </div>
            <table class="tableau-contenu">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Coordonnées</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blocRole['items'] as $user)
                        @php
                            $photo = $user->profile_photo_path ? \Illuminate\Support\Facades\Storage::url($user->profile_photo_path) : null;
                            $initiale = mb_strtoupper(mb_substr(trim((string) $user->nom), 0, 1));
                        @endphp
                        <tr>
                            <td>
                                <div class="profil-mini">
                                    <span class="avatar-mini">@if($photo)<img src="{{ $photo }}" alt="Photo de {{ $user->nom }}">@else{{ $initiale }}@endif</span>
                                    <div class="infos">
                                        <strong>{{ $user->nom }}</strong>
                                        <p>{{ $user->role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $user->email }}</div>
                                <div class="text-muted small">{{ $user->telephone ?: 'Téléphone non renseigné' }}</div>
                                <div class="text-muted small">{{ $user->adresse ?: 'Adresse non renseignée' }}</div>
                            </td>
                            <td>
                                <span class="badge-etat {{ $user->actif ? 'badge-actif' : 'badge-inactif' }}">{{ $user->actif ? 'Actif' : 'Inactif' }}</span>
                            </td>
                            <td>
                                <div class="actions-ligne">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
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
                            <td colspan="4" class="text-muted">Aucun utilisateur dans cette catégorie.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-2">
                {{ $blocRole['items']->links() }}
            </div>
        </section>
    @endforeach
</div>
@endsection
