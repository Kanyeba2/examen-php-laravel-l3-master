@extends('layouts.app')

@section('content')
<style>
    .page-paiements {
        background: linear-gradient(180deg, #f7f9fd 0%, #eef3fb 100%);
        border: 1px solid #d8e3f3;
        border-radius: 16px;
        padding: 0.75rem;
    }

    .hero-paiements {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.65rem 0.85rem 0.9rem;
        border-bottom: 1px solid rgba(210, 222, 240, 0.9);
        margin-bottom: 0.85rem;
    }

    .entete-page {
        margin-bottom: 0;
        max-width: 70%;
    }

    .entete-page h2 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        color: #1f2e4a;
        letter-spacing: -0.02em;
    }

    .entete-page p {
        margin: 0.25rem 0 0;
        color: #67748e;
        font-size: 0.92rem;
    }

    .badge-resume {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.65rem;
        border-radius: 999px;
        border: 1px solid #d6e1f3;
        background: rgba(255, 255, 255, 0.8);
        color: #27406b;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .resume-paiement-courant {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.45rem;
        flex-shrink: 0;
    }

    .resume-paiement-courant small {
        color: #6b7b96;
        font-size: 0.78rem;
    }

    .grille-stats {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.55rem;
        margin-bottom: 0.85rem;
    }

    .carte-stat {
        border-radius: 14px;
        padding: 0.7rem 0.75rem;
        color: #fff;
        box-shadow: 0 8px 18px rgba(21, 36, 65, 0.1);
        position: relative;
        overflow: hidden;
    }

    .carte-stat::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.12), transparent 55%);
        pointer-events: none;
    }

    .carte-stat h3 {
        margin: 0 0 0.15rem;
        font-size: 0.76rem;
        font-weight: 700;
        opacity: 0.92;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .carte-stat .valeur {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .carte-stat.total { background: linear-gradient(135deg, #264a86, #1f3562); }
    .carte-stat.success { background: linear-gradient(135deg, #1f7a4d, #15563c); }
    .carte-stat.pending { background: linear-gradient(135deg, #8a5c12, #6e4a0e); }
    .carte-stat.failed { background: linear-gradient(135deg, #bf3f51, #8a2433); }
    .carte-stat.amount { background: linear-gradient(135deg, #4f6fef, #2749b2); }

    .panneau-filtres {
        border: 1px solid #dbe5f4;
        border-radius: 14px;
        background: #fff;
        padding: 0.75rem;
        margin-bottom: 0.85rem;
        box-shadow: 0 8px 18px rgba(23, 39, 72, 0.05);
    }

    .panneau-filtres .form-control,
    .panneau-filtres .form-select,
    .panneau-filtres .btn {
        border-radius: 10px;
        min-height: 40px;
    }

    .bloc-tableau {
        border: 1px solid #dbe5f4;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(23, 39, 72, 0.06);
        overflow: hidden;
    }

    .table-paiements th {
        font-weight: 800;
        color: #203050;
        white-space: nowrap;
        font-size: 0.8rem;
        border-bottom: 1px solid #e6edf8;
    }

    .table-paiements td {
        vertical-align: top;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        font-size: 0.9rem;
        border-color: #edf2f8;
    }

    .table-paiements tbody tr:nth-child(odd) {
        background: #fcfdff;
    }

    .table-paiements tbody tr:hover {
        background: #f4f8ff;
    }

    .badge-statut {
        border-radius: 999px;
        padding: 0.25rem 0.7rem;
        font-size: 0.76rem;
        font-weight: 700;
        display: inline-block;
    }

    .statut-reussi { background: #def4e2; color: #1f7a36; }
    .statut-attente { background: #fff2d8; color: #946200; }
    .statut-echoue { background: #fce1e1; color: #992727; }

    .detail-ligne {
        color: #5f6f8c;
        font-size: 0.8rem;
        margin-top: 0.06rem;
    }

    .mini-bloc {
        display: flex;
        flex-direction: column;
        gap: 0.08rem;
    }

    .mini-bloc strong {
        color: #203050;
        line-height: 1.2;
    }

    .actions-pdf {
        display: flex;
        gap: 0.35rem;
        flex-wrap: wrap;
    }

    .btn-pdf-soft {
        border-color: #cfd9ea;
        color: #35507f;
        background: linear-gradient(180deg, #fff 0%, #f6f9ff 100%);
    }

    .btn-pdf-soft:hover {
        border-color: #b8c8e2;
        color: #203050;
        background: #eef4ff;
    }

    .section-recentes {
        margin-top: 0.9rem;
        padding-top: 0.2rem;
    }

    .liste-recentes {
        display: grid;
        gap: 0.45rem;
    }

    .carte-recente {
        border: 1px solid #e1e9f6;
        border-radius: 12px;
        padding: 0.65rem 0.75rem;
        background: #fbfcff;
    }

    .bloc-recentes-entete {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.55rem;
    }

    .bloc-recentes-entete h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #203050;
    }

    .bloc-recentes-entete span {
        color: #6b7b96;
        font-size: 0.84rem;
    }

    .table-responsive {
        max-height: 700px;
    }

    @media (max-width: 1199px) {
        .grille-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .grille-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-paiements">
    <div class="hero-paiements">
        <div class="entete-page">
            <h2>Paiements clients</h2>
            <p>Vue globale de tous les paiements effectués, avec les clients, les demandes et les factures PDF.</p>
        </div>
        <div class="resume-paiement-courant">
            <span class="badge-resume"><i class="bi bi-receipt"></i> Factures disponibles</span>
            <small>{{ $payments->total() }} paiements au total</small>
        </div>
    </div>

    <div class="grille-stats">
        <div class="carte-stat total"><h3>Total transactions</h3><p class="valeur">{{ $paymentStats['total'] }}</p></div>
        <div class="carte-stat success"><h3>Réussis</h3><p class="valeur">{{ $paymentStats['reussi'] }}</p></div>
        <div class="carte-stat pending"><h3>En attente</h3><p class="valeur">{{ $paymentStats['en_attente'] }}</p></div>
        <div class="carte-stat failed"><h3>Échoués</h3><p class="valeur">{{ $paymentStats['echoue'] }}</p></div>
        <div class="carte-stat amount"><h3>Total encaissé</h3><p class="valeur">{{ number_format((float) $paymentStats['montant_total'], 2, ',', ' ') }} $</p></div>
    </div>

    <form method="GET" class="panneau-filtres row g-2 align-items-end">
        <div class="col-lg-3">
            <input type="text" name="search" class="form-control" placeholder="Reference, client, animal" value="{{ request('search') }}">
        </div>
        <div class="col-lg-2 col-md-4">
            <select name="statut" class="form-select">
                <option value="">Tous statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="reussi" {{ request('statut') === 'reussi' ? 'selected' : '' }}>Réussi</option>
                <option value="echoue" {{ request('statut') === 'echoue' ? 'selected' : '' }}>Échoué</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4">
            <select name="fournisseur" class="form-select">
                <option value="">Tous fournisseurs</option>
                <option value="mpesa" {{ request('fournisseur') === 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                <option value="airtel" {{ request('fournisseur') === 'airtel' ? 'selected' : '' }}>Airtel</option>
                <option value="orange" {{ request('fournisseur') === 'orange' ? 'selected' : '' }}>Orange</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4">
            <input type="text" name="client" class="form-control" placeholder="Client" value="{{ request('client') }}">
        </div>
        <div class="col-lg-2 col-md-4">
            <input type="text" name="animal" class="form-control" placeholder="Animal" value="{{ request('animal') }}">
        </div>
        <div class="col-lg-1 col-md-3 d-grid">
            <button class="btn btn-primary">OK</button>
        </div>
        <div class="col-lg-2 col-md-6">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-lg-2 col-md-6">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
    </form>

    <div class="bloc-tableau">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0 table-paiements">
                <thead class="table-light sticky-top">
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Demande / Animal</th>
                        <th>Fournisseur</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <div class="mini-bloc">
                                    <strong>{{ $payment->reference_interne }}</strong>
                                    <span class="detail-ligne">{{ $payment->created_at?->format('d/m/Y H:i') }}</span>
                                    @if($payment->reference_fournisseur)
                                        <span class="detail-ligne">Ref fournisseur: {{ $payment->reference_fournisseur }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="mini-bloc">
                                    <strong>{{ $payment->utilisateur->nom ?? 'Client' }}</strong>
                                    <span class="detail-ligne">{{ $payment->utilisateur->email ?? 'N/A' }}</span>
                                    <span class="detail-ligne">{{ $payment->numero_telephone ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($payment->demandeAdoption)
                                    <div class="mini-bloc">
                                        <strong>Demande #{{ $payment->demandeAdoption->id }}</strong>
                                        <span class="detail-ligne">Animal: {{ $payment->demandeAdoption->animal?->nom ?? 'N/A' }}</span>
                                        <span class="detail-ligne">Espèce: {{ $payment->demandeAdoption->animal?->espece ?? 'N/A' }}</span>
                                    </div>
                                @else
                                    <span class="detail-ligne">Paiement libre sans demande liée.</span>
                                @endif
                            </td>
                            <td>{{ strtoupper($payment->fournisseur) }}</td>
                            <td>
                                <div class="mini-bloc">
                                    <strong>{{ number_format((float) $payment->montant, 2, ',', ' ') }} {{ $payment->devise }}</strong>
                                    @if($payment->demandeAdoption)
                                        <span class="detail-ligne">Montant attendu: {{ number_format((float) ($payment->demandeAdoption->animal?->prix_adoption ?? $payment->montant), 2, ',', ' ') }} $</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($payment->statut === 'reussi')
                                    <span class="badge-statut statut-reussi">Réussi</span>
                                @elseif($payment->statut === 'echoue')
                                    <span class="badge-statut statut-echoue">Échoué</span>
                                @else
                                    <span class="badge-statut statut-attente">En attente</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-pdf">
                                    <a href="{{ route('admin.payments.pdf', $payment) }}" class="btn btn-sm btn-outline-secondary btn-pdf-soft">PDF</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-light border mb-0">Aucun paiement trouvé.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($payments->hasPages())
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <div class="text-muted small">Page {{ $payments->currentPage() }} sur {{ $payments->lastPage() }}</div>
            <div class="d-flex gap-2">
                @if($payments->onFirstPage())
                    <span class="btn btn-outline-secondary disabled">Précédent</span>
                @else
                    <a href="{{ $payments->previousPageUrl() }}" class="btn btn-outline-secondary">Précédent</a>
                @endif

                @if($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}" class="btn btn-primary">Suivant</a>
                @else
                    <span class="btn btn-primary disabled">Suivant</span>
                @endif
            </div>
        </div>
    @endif

    <div class="section-recentes">
        <div class="bloc-recentes-entete">
            <h4>Paiements récents</h4>
            <span>{{ $recentPayments->count() }} éléments</span>
        </div>
        <div class="liste-recentes">
            @foreach($recentPayments as $payment)
                <div class="carte-recente">
                    <strong>{{ $payment->reference_interne }}</strong>
                    <div class="text-muted small">{{ $payment->utilisateur->nom ?? 'Client' }} · {{ $payment->demandeAdoption?->animal?->nom ?? 'Aucune demande' }} · {{ number_format((float) $payment->montant, 2, ',', ' ') }} {{ $payment->devise }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection