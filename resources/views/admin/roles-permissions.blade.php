@extends('layouts.app')

@section('content')
<style>
    .page-admin {
        background: #f7f9fc;
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 0.95rem;
    }

    .grille-kpi {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.7rem;
        margin: 0.95rem 0;
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

    .bloc-entete h2 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #22314f;
    }

    .tableau-permissions {
        width: 100%;
        border-collapse: collapse;
    }

    .tableau-permissions th,
    .tableau-permissions td {
        padding: 0.72rem 0.9rem;
        border-bottom: 1px solid #edf2f8;
        vertical-align: middle;
    }

    .tableau-permissions th {
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.72rem;
        color: #72809b;
        background: #fbfcfe;
    }

    .matrice {
        display: grid;
        gap: 0.85rem;
    }

    .role-block {
        border: 1px solid #e3ebf6;
        border-radius: 14px;
        background: #fbfcff;
        padding: 0.8rem;
    }

    .role-block h3 {
        margin: 0 0 0.6rem;
        font-size: 0.98rem;
        font-weight: 800;
        color: #203050;
    }

    .liste-permissions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 0.6rem;
    }

    .permission-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        border: 1px solid #e3ebf6;
        border-radius: 12px;
        background: #fff;
        padding: 0.7rem;
    }

    .permission-item label {
        margin: 0;
        font-weight: 700;
        color: #344867;
    }

    .permission-item small {
        color: #70809e;
        display: block;
    }

    .form-check-input {
        width: 2.4rem;
        height: 1.25rem;
    }

    .zone-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    @media (max-width: 1100px) {
        .grille-kpi {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-admin">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <h2 class="mb-0">Rôles et permissions</h2>
            <p class="text-muted mb-0">Gestion des droits par rôle depuis la base de données.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Voir les utilisateurs</a>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi"><p class="libelle">Rôles</p><p class="valeur">3</p></div>
        <div class="carte-kpi"><p class="libelle">Permissions suivies</p><p class="valeur">{{ $permissions->count() }}</p></div>
        <div class="carte-kpi"><p class="libelle">Administrateur</p><p class="valeur">Actif</p></div>
        <div class="carte-kpi"><p class="libelle">Synchronisation</p><p class="valeur">DB</p></div>
    </div>

    <form method="POST" action="{{ route('admin.roles.update') }}">
        @csrf
        <div class="matrice">
            @foreach(['admin' => 'Administrateur', 'manager' => 'Gestionnaire', 'client' => 'Client'] as $role => $label)
                <section class="role-block">
                    <h3>{{ $label }}</h3>
                    <div class="liste-permissions">
                        @foreach($permissions as $permission => $permissionLabel)
                            @php($enabled = $matrice[$role][$permission] ?? false)
                            <div class="permission-item">
                                <div>
                                    <label>{{ $permissionLabel }}</label>
                                    <small>{{ $permission }}</small>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="permissions[{{ $role }}][{{ $permission }}]" value="1" @checked($enabled)>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <div class="zone-actions">
            <button type="submit" class="btn btn-primary">Enregistrer les permissions</button>
        </div>
    </form>
</div>
@endsection
