@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .page-logs {
        background: radial-gradient(circle at 0% 0%, #ebf1ff, #f4f7fc 40%), #f4f7fc;
        border: 1px solid #dce5f3;
        border-radius: 18px;
        padding: 1rem;
        color: #172037;
    }

    .entete-logs {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 0.9rem;
    }

    .entete-logs h2 {
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }

    .sous-titre-logs {
        margin: 0.2rem 0 0;
        color: #647392;
    }

    .kpi-logs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .kpi-logs .kpi {
        background: #fff;
        border: 1px solid #d9e3f4;
        border-radius: 10px;
        padding: 0.45rem 0.65rem;
        font-size: 0.78rem;
        color: #506185;
        min-width: 120px;
        text-align: center;
    }

    .kpi-logs .kpi strong {
        display: block;
        font-size: 1.05rem;
        line-height: 1.15;
        color: #1e2a45;
    }

    .bloc-filtres {
        border: 1px solid #d8e2f3;
        border-radius: 14px;
        background: #f8fbff;
        padding: 0.8rem;
        margin-bottom: 1rem;
    }

    .bloc-filtres .form-control,
    .bloc-filtres .form-select,
    .bloc-filtres .btn {
        border-radius: 10px;
    }

    .bloc-filtres .form-label {
        font-size: 0.76rem;
        font-weight: 600;
        color: #627391;
        margin-bottom: 0.25rem;
    }

    .actions-filtres {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 0.35rem;
    }

    .resultats-live-logs {
        display: none;
        border: 1px solid #d8e2f3;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .tableau-logs {
        border: 1px solid #d8e2f3;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 22px rgba(23, 37, 71, 0.06);
        overflow: hidden;
    }

    .tableau-logs table {
        margin: 0;
    }

    .tableau-logs thead th {
        background: #f5f8fd;
        color: #516282;
        font-size: 0.8rem;
        font-weight: 700;
        border-bottom: 1px solid #e2e9f5;
        white-space: nowrap;
    }

    .tableau-logs td {
        font-size: 0.9rem;
        color: #1f2d4a;
        vertical-align: middle;
    }

    .tableau-logs tbody tr:hover {
        background: #f9fbff;
    }

    .texte-action {
        font-family: "Consolas", "Courier New", monospace;
        font-size: 0.82rem;
        color: #27395f;
    }

    .pastille-niveau {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border-radius: 999px;
        border: 1px solid transparent;
        padding: 0.15rem 0.55rem;
        font-size: 0.73rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .niveau-info {
        background: #e9f1ff;
        border-color: #c9daf6;
        color: #38578d;
    }

    .niveau-warning {
        background: #f7efde;
        border-color: #e7d8b6;
        color: #8b6721;
    }

    .niveau-critical {
        background: #f8e7eb;
        border-color: #ebced6;
        color: #933a4d;
    }

    .boutons-ligne {
        display: flex;
        gap: 0.35rem;
        flex-wrap: wrap;
    }

    .ligne-details {
        background: #fbfcff;
    }

    .boite-details {
        border: 1px dashed #d6e0f1;
        border-radius: 10px;
        padding: 0.65rem;
        font-size: 0.86rem;
        color: #32466f;
        line-height: 1.45;
    }

    .boite-details .meta {
        color: #667796;
        font-size: 0.78rem;
        margin-bottom: 0.25rem;
    }

    .pagination-logs {
        margin-top: 0.85rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .pagination-logs .info {
        color: #60708f;
        font-size: 0.86rem;
    }

    .pagination-logs .actions {
        display: flex;
        gap: 0.45rem;
    }

    @media (max-width: 992px) {
        .entete-logs {
            flex-direction: column;
        }

        .kpi-logs {
            justify-content: flex-start;
        }
    }
</style>

@php
    $texteSource = static fn ($log) => mb_strtolower(($log->action ?? '').' '.($log->description ?? ''));
    $determinerNiveau = static function ($log) use ($texteSource): array {
        $texte = $texteSource($log);

        if (str_contains($texte, 'suppression') || str_contains($texte, 'erreur')) {
            return ['critical', 'Critique'];
        }

        if (str_contains($texte, 'echec') || str_contains($texte, 'refus') || str_contains($texte, 'invalide') || str_contains($texte, 'inactif')) {
            return ['warning', 'Alerte'];
        }

        return ['info', 'Info'];
    };

    $totalLogs = $logs->total();
    $logsCritiques = $logs->getCollection()->filter(fn ($log) => $determinerNiveau($log)[0] === 'critical')->count();
    $logsAlertes = $logs->getCollection()->filter(fn ($log) => $determinerNiveau($log)[0] === 'warning')->count();
    $logsSysteme = $logs->getCollection()->filter(fn ($log) => is_null($log->utilisateur_id))->count();
    $paramsBase = request()->except('logs_page');
@endphp

<div class="page-logs">
    <div class="entete-logs">
        <div>
            <h2>Logs & Traçabilité</h2>
            <p class="sous-titre-logs">Centre de supervision des événements, contrôles et actions sensibles.</p>
        </div>
        <div class="kpi-logs">
            <div class="kpi"><strong>{{ $totalLogs }}</strong>Total logs</div>
            <div class="kpi"><strong>{{ $logsAlertes }}</strong>Alertes</div>
            <div class="kpi"><strong>{{ $logsCritiques }}</strong>Critiques</div>
            <div class="kpi"><strong>{{ $logsSysteme }}</strong>Système</div>
        </div>
    </div>

    <form method="GET" class="bloc-filtres row g-2">
        <div class="col-lg-3 col-md-6">
            <label class="form-label" for="recherche-live-logs">Recherche globale</label>
            <input type="text" id="recherche-live-logs" name="log_search" class="form-control" placeholder="Action, description, entité, utilisateur" value="{{ request('log_search') }}">
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Utilisateur</label>
            <input type="text" name="log_user" class="form-control" placeholder="Nom utilisateur" value="{{ request('log_user') }}">
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Action</label>
            <input type="text" name="log_action" class="form-control" placeholder="Ex: otp" value="{{ request('log_action') }}">
        </div>
        <div class="col-lg-2 col-md-6">
            <label class="form-label">Entité</label>
            <input type="text" name="log_entity" class="form-control" placeholder="Ex: user" value="{{ request('log_entity') }}">
        </div>
        <div class="col-lg-1 col-md-6">
            <label class="form-label">Niveau</label>
            <select name="log_level" class="form-select">
                <option value="">Tous</option>
                <option value="info" {{ request('log_level') === 'info' ? 'selected' : '' }}>Info</option>
                <option value="warning" {{ request('log_level') === 'warning' ? 'selected' : '' }}>Alerte</option>
            </select>
        </div>
        <div class="col-lg-1 col-md-6">
            <label class="form-label">Du</label>
            <input type="date" name="log_from" class="form-control" value="{{ request('log_from') }}">
        </div>
        <div class="col-lg-1 col-md-6">
            <label class="form-label">Au</label>
            <input type="date" name="log_to" class="form-control" value="{{ request('log_to') }}">
        </div>
        <div class="col-12 actions-filtres">
            <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i> Filtrer</button>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-clockwise"></i> Réinitialiser</a>
            <button type="button" id="exporter-logs-csv" class="btn btn-outline-dark btn-sm"><i class="bi bi-download"></i> Exporter CSV (page)</button>
        </div>
    </form>

    <div id="resultats-live-logs" class="list-group resultats-live-logs"></div>

    <div class="tableau-logs">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Niveau</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Entité</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            [$niveauCode, $niveauLabel] = $determinerNiveau($log);
                            $desc = $log->description ?: 'Aucune description.';
                            $actionFiltre = route('admin.logs.index', array_merge($paramsBase, ['log_action' => $log->action]));
                            $entityFiltre = route('admin.logs.index', array_merge($paramsBase, ['log_entity' => $log->type_entite]));
                            $userFiltre = route('admin.logs.index', array_merge($paramsBase, ['log_user' => $log->user->nom ?? '']));
                        @endphp
                        <tr>
                            <td class="text-nowrap">{{ $log->created_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="pastille-niveau niveau-{{ $niveauCode }}">
                                    <i class="bi bi-record-fill"></i>{{ $niveauLabel }}
                                </span>
                            </td>
                            <td>{{ $log->user->nom ?? 'Système' }}</td>
                            <td><span class="texte-action">{{ $log->action }}</span></td>
                            <td>{{ $log->type_entite ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($desc, 88) }}</td>
                            <td>
                                <div class="boutons-ligne">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#details-log-{{ $log->id }}" aria-expanded="false" aria-controls="details-log-{{ $log->id }}">Détails</button>
                                    <a href="{{ $actionFiltre }}" class="btn btn-outline-primary btn-sm">Action</a>
                                    @if(!empty($log->type_entite))
                                        <a href="{{ $entityFiltre }}" class="btn btn-outline-primary btn-sm">Entité</a>
                                    @endif
                                    @if(!empty($log->user?->nom))
                                        <a href="{{ $userFiltre }}" class="btn btn-outline-primary btn-sm">Utilisateur</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr class="ligne-details collapse" id="details-log-{{ $log->id }}">
                            <td colspan="7">
                                <div class="boite-details">
                                    <div class="meta">Entrée #{{ $log->id }} · {{ $log->created_at?->format('d/m/Y H:i:s') }} · Entité ID: {{ $log->entite_id ?? 'N/A' }}</div>
                                    <div>{{ $desc }}</div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted text-center py-4">Aucun log trouvé avec ces critères.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-logs">
        <div class="info">
            Page {{ $logs->currentPage() }} / {{ $logs->lastPage() }} · {{ $logs->total() }} résultat(s)
        </div>
        <div class="actions">
            @if($logs->onFirstPage())
                <span class="btn btn-outline-secondary btn-sm disabled" aria-disabled="true">Précédent</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm">Précédent</a>
            @endif

            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="btn btn-primary btn-sm">Suivant</a>
            @else
                <span class="btn btn-primary btn-sm disabled" aria-disabled="true">Suivant</span>
            @endif
        </div>
    </div>
</div>

<script>
    const entreeRechercheLogs = document.getElementById('recherche-live-logs');
    const blocResultatsLogs = document.getElementById('resultats-live-logs');
    let minuteurLogs;

    function masquerResultatsLogs() {
        blocResultatsLogs.style.display = 'none';
        blocResultatsLogs.innerHTML = '';
    }

    entreeRechercheLogs?.addEventListener('input', () => {
        const terme = entreeRechercheLogs.value.trim();
        clearTimeout(minuteurLogs);

        if (terme.length < 2) {
            masquerResultatsLogs();
            return;
        }

        minuteurLogs = setTimeout(async () => {
            try {
                const reponse = await fetch(`{{ route('admin.logs.search') }}?q=${encodeURIComponent(terme)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await reponse.json();
                const elements = json.data || [];

                if (!elements.length) {
                    masquerResultatsLogs();
                    return;
                }

                blocResultatsLogs.innerHTML = elements.map(element => (
                    `<div class="list-group-item">`
                    + `<div class="small text-muted">${element.created_at}</div>`
                    + `<div><strong>${element.action}</strong> (${element.entity ?? ''})</div>`
                    + `<div class="small">${element.description ?? ''}</div>`
                    + `<div class="small text-muted">Par ${element.user}</div>`
                    + `</div>`
                )).join('');
                blocResultatsLogs.style.display = 'block';
            } catch (error) {
                masquerResultatsLogs();
            }
        }, 250);
    });

    document.getElementById('exporter-logs-csv')?.addEventListener('click', () => {
        const entete = ['Date', 'Niveau', 'Utilisateur', 'Action', 'Entite', 'Description'];
        const lignes = [entete.join(';')];
        document.querySelectorAll('.tableau-logs tbody tr').forEach((ligne) => {
            if (ligne.classList.contains('ligne-details') || ligne.querySelector('td[colspan]')) {
                return;
            }

            const cellules = Array.from(ligne.querySelectorAll('td')).slice(0, 6).map((cellule) => {
                const texte = cellule.innerText.replace(/\s+/g, ' ').trim().replace(/"/g, '""');
                return `"${texte}"`;
            });

            if (cellules.length) {
                lignes.push(cellules.join(';'));
            }
        });

        const csv = new Blob([lignes.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const lien = document.createElement('a');
        lien.href = URL.createObjectURL(csv);
        lien.download = `logs-page-${new Date().toISOString().slice(0, 10)}.csv`;
        document.body.appendChild(lien);
        lien.click();
        lien.remove();
    });
</script>
@endsection
