@extends('layouts.app')

@section('content')
<style>
    .page-admin {
        background: #f7f9fc;
        border: 1px solid #dbe4f2;
        border-radius: 18px;
        padding: 0.95rem;
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
    }

    .bloc-entete h2 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #22314f;
    }

    .bloc-corps {
        padding: 0.95rem;
    }

    .form-label {
        font-weight: 700;
        color: #344867;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border-color: #d7e1ef;
    }

    .zone-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .grille-kpi {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
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

    @media (max-width: 1100px) {
        .grille-kpi {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .grille-kpi {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-admin">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
        <div>
            <h2 class="mb-0">Fixer paiement</h2>
            <p class="text-muted mb-0">Configuration centrale du site, y compris le montant d'adoption appliqué au client.</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">Gérer les permissions</a>
    </div>

    <div class="grille-kpi">
        <div class="carte-kpi"><p class="libelle">Application</p><p class="valeur">{{ $parametres['app_name'] }}</p></div>
        <div class="carte-kpi"><p class="libelle">Langue</p><p class="valeur">{{ strtoupper($parametres['default_language']) }}</p></div>
        <div class="carte-kpi"><p class="libelle">Maintenance</p><p class="valeur">{{ $parametres['maintenance_mode'] ? 'ON' : 'OFF' }}</p></div>
        <div class="carte-kpi"><p class="libelle">Statut publication</p><p class="valeur">{{ $parametres['publication_default_status'] === 'published' ? 'Publié' : 'Brouillon' }}</p></div>
        <div class="carte-kpi"><p class="libelle">Frais adoption</p><p class="valeur">{{ number_format((float) $parametres['default_adoption_fee'], 2, ',', ' ') }} $</p></div>
    </div>

    <div class="bloc">
        <div class="bloc-entete">
            <h2>Paramètres généraux</h2>
        </div>
        <div class="bloc-corps">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="app_name">Nom de l application</label>
                        <input id="app_name" type="text" class="form-control" name="app_name" value="{{ old('app_name', $parametres['app_name']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="support_email">Email support</label>
                        <input id="support_email" type="email" class="form-control" name="support_email" value="{{ old('support_email', $parametres['support_email']) }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label" for="support_phone">Téléphone support</label>
                        <input id="support_phone" type="text" class="form-control" name="support_phone" value="{{ old('support_phone', $parametres['support_phone']) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="support_address">Adresse support</label>
                        <input id="support_address" type="text" class="form-control" name="support_address" value="{{ old('support_address', $parametres['support_address']) }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label" for="default_adoption_fee">Frais d adoption par défaut</label>
                        <input id="default_adoption_fee" type="number" min="0" step="0.01" class="form-control" name="default_adoption_fee" value="{{ old('default_adoption_fee', $parametres['default_adoption_fee']) }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label" for="default_language">Langue par défaut</label>
                        <select id="default_language" name="default_language" class="form-select">
                            <option value="fr" @selected(old('default_language', $parametres['default_language']) === 'fr')>Français</option>
                            <option value="en" @selected(old('default_language', $parametres['default_language']) === 'en')>Anglais</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="publication_default_status">Statut de publication par défaut</label>
                        <select id="publication_default_status" name="publication_default_status" class="form-select">
                            <option value="draft" @selected(old('publication_default_status', $parametres['publication_default_status']) === 'draft')>Brouillon</option>
                            <option value="published" @selected(old('publication_default_status', $parametres['publication_default_status']) === 'published')>Publié</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" @checked(old('maintenance_mode', $parametres['maintenance_mode']))>
                            <label class="form-check-label" for="maintenance_mode">Mode maintenance</label>
                        </div>
                    </div>
                </div>

                <div class="zone-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer les paramètres</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
