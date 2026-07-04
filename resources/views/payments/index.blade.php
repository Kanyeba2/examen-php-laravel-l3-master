@extends('layouts.app')

@section('content')
<style>
    .paiements-coquille {
        background: #f7f9f8;
        border: 1px solid #e5ece7;
        border-radius: 16px;
        padding: 1rem;
    }

    .paiements-entete {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: .75rem;
        flex-wrap: wrap;
        margin-bottom: .9rem;
    }

    .paiements-titre {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .paiements-sous-titre {
        margin: .15rem 0 0;
        color: #5d6a62;
        font-size: .92rem;
    }

    .cartes-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .6rem;
        width: 100%;
        margin-bottom: 1rem;
    }

    .carte-stat {
        border: 1px solid #dde7de;
        border-radius: 12px;
        background: #fff;
        padding: .7rem .8rem;
    }

    .carte-stat small {
        color: #65736b;
        display: block;
        margin-bottom: .12rem;
    }

    .carte-stat strong {
        font-size: 1.2rem;
        color: #213227;
    }

    .carte-stat .detail-stat {
        margin-top: .12rem;
        color: #6a766f;
        font-size: .8rem;
        line-height: 1.35;
    }

    .graphique-statuts {
        border: 1px solid #dce6de;
        border-radius: 12px;
        background: #ffffff;
        padding: .7rem .8rem;
        margin-bottom: 1rem;
    }

    .piste-statuts {
        display: grid;
        grid-template-columns: 1fr;
        border-radius: 999px;
        overflow: hidden;
        height: 12px;
        background: #edf2ee;
        margin-bottom: .55rem;
    }

    .pile-statuts {
        display: flex;
        width: 100%;
        height: 100%;
    }

    .segment-reussi { background: #2f7d3f; }
    .segment-attente { background: #c48a08; }
    .segment-echoue { background: #be3f3f; }

    .legende-graphique {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        font-size: .82rem;
        color: #4f5f54;
    }

    .point-legende {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        margin-right: .28rem;
    }

    .panneau-filtres {
        border: 1px solid #dce6de;
        border-radius: 12px;
        background: #f3f7f3;
        padding: .75rem;
        margin-bottom: 1rem;
    }

    .panneau-filtres .form-control,
    .panneau-filtres .form-select,
    .panneau-filtres .btn {
        height: 42px;
        border-radius: 10px;
    }

    .panneau {
        border: 1px solid #dee8e0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(27, 40, 31, .06);
        height: 100%;
    }

    .panneau .form-control,
    .panneau .form-select,
    .panneau .btn {
        border-radius: 10px;
    }

    .table-historique th {
        font-weight: 700;
        color: #233329;
        border-bottom-width: 1px;
    }

    .table-historique td {
        vertical-align: top;
    }

    .pastille-statut {
        display: inline-block;
        border-radius: 999px;
        padding: .2rem .55rem;
        font-size: .75rem;
        font-weight: 700;
    }

    .statut-reussi { background: #def4e2; color: #1f7a36; }
    .statut-attente { background: #fff2d8; color: #946200; }
    .statut-echoue { background: #fce1e1; color: #992727; }

    .ligne-vide {
        border: 1px dashed #d4e0d5;
        border-radius: 10px;
        padding: .9rem;
        background: #fbfdfb;
        color: #5f6c63;
        text-align: center;
    }

    .pagination-coquille {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .75rem;
        margin-top: .8rem;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #5f6b66;
        font-size: .88rem;
    }

    .pagination-actions {
        display: flex;
        gap: .5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-pagination {
        border-radius: 9px;
        min-width: 116px;
    }

    .pagination-pages {
        display: flex;
        gap: .35rem;
        align-items: center;
    }

    .pagination-page {
        min-width: 36px;
        height: 36px;
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

    @media (max-width: 1199px) {
        .cartes-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 767px) {
        .paiements-titre { font-size: 1.65rem; }
        .cartes-stats { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    }
</style>

<div class="paiements-coquille">
    @php
        $totalDesTransactions = max(1, (int) $paymentStats['total']);
        $pourcentReussi = (int) round(((int) $paymentStats['reussi'] / $totalDesTransactions) * 100);
        $pourcentAttente = (int) round(((int) $paymentStats['en_attente'] / $totalDesTransactions) * 100);
        $pourcentEchoue = max(0, 100 - $pourcentReussi - $pourcentAttente);
    @endphp

    <div class="paiements-entete">
        <div>
            <h2 class="paiements-titre">Paiements mobiles</h2>
            <p class="paiements-sous-titre">Initiez un paiement et suivez vos transactions en temps reel.</p>
        </div>
    </div>

    <div class="cartes-stats">
        <div class="carte-stat"><small>Total des transactions</small><strong>{{ $paymentStats['total'] }}</strong></div>
        <div class="carte-stat"><small>Reussies</small><strong>{{ $paymentStats['reussi'] }}</strong></div>
        <div class="carte-stat"><small>En attente</small><strong>{{ $paymentStats['en_attente'] }}</strong></div>
        <div class="carte-stat"><small>Echouees</small><strong>{{ $paymentStats['echoue'] }}</strong></div>
        <div class="carte-stat">
            <small>Total payé</small>
            <strong>{{ number_format((float) $paymentStats['montant_total_paye'], 2, ',', ' ') }} $</strong>
            <div class="detail-stat">Somme des paiements marqués comme reussis.</div>
        </div>
        <div class="carte-stat">
            <small>Dernier paiement validé</small>
            <strong>{{ $dernierPaiementReussi?->reference_interne ?? 'Aucun' }}</strong>
            <div class="detail-stat">{{ $dernierPaiementReussi?->created_at?->format('d/m/Y H:i') ?? 'Aucun paiement confirme' }}</div>
        </div>
    </div>

    @if($dernierPaiementReussi)
        <div class="alert alert-success border-0 shadow-sm mb-3">
            <strong>Paiement confirmé.</strong>
            {{ $dernierPaiementReussi->reference_interne }} pour
            {{ $dernierPaiementReussi->demandeAdoption?->animal?->nom ?? 'la demande' }} a bien été enregistré comme payé.
        </div>
    @endif

    <div class="graphique-statuts">
        <div class="piste-statuts">
            <div class="pile-statuts">
                <div class="segment-reussi" data-largeur="{{ $pourcentReussi }}"></div>
                <div class="segment-attente" data-largeur="{{ $pourcentAttente }}"></div>
                <div class="segment-echoue" data-largeur="{{ $pourcentEchoue }}"></div>
            </div>
        </div>
        <div class="legende-graphique">
            <span><span class="point-legende segment-reussi"></span>Reussies: {{ $pourcentReussi }}%</span>
            <span><span class="point-legende segment-attente"></span>En attente: {{ $pourcentAttente }}%</span>
            <span><span class="point-legende segment-echoue"></span>Echouees: {{ $pourcentEchoue }}%</span>
        </div>
    </div>

    <form method="GET" class="panneau-filtres row g-2">
        <div class="col-lg-3">
            <input type="text" name="search" class="form-control" placeholder="Reference / telephone" value="{{ request('search') }}">
        </div>
        <div class="col-lg-2 col-md-4">
            <select name="statut" class="form-select">
                <option value="">Tous statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="reussi" {{ request('statut') === 'reussi' ? 'selected' : '' }}>Reussi</option>
                <option value="echoue" {{ request('statut') === 'echoue' ? 'selected' : '' }}>Echoue</option>
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
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-lg-2 col-md-6">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-lg-1 col-md-3 d-grid">
            <button class="btn btn-primary">OK</button>
        </div>
    </form>

    <div class="row g-4">
        <div class="col-lg-5">
            <section class="panneau p-3 p-lg-4">
                <h5 class="mb-1">Initier un paiement</h5>
                <p class="text-muted small mb-3">Selectionnez une demande et lancez votre transaction en securite.</p>

                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Demande d'adoption (optionnel)</label>
                        <select name="demande_adoption_id" id="demande_adoption_id" class="form-select">
                            <option value="">Aucune</option>
                            @foreach($adoptionRequests as $demande)
                                <option
                                    value="{{ $demande->id }}"
                                    data-montant="{{ number_format((float) $demande->montant_a_payer, 2, '.', '') }}"
                                    data-devise="USD"
                                >
                                    #{{ $demande->id }} - {{ $demande->animal->nom ?? 'Animal' }} · {{ number_format((float) $demande->montant_a_payer, 2, ',', ' ') }} $ ({{ $demande->statut }})
                                </option>
                            @endforeach
                        </select>
                        <div class="aide-fichier mt-1">Quand une demande est choisie, le montant est fixé automatiquement selon le tarif de l'animal.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fournisseur</label>
                        <select name="fournisseur" class="form-select" required>
                            <option value="mpesa">M-Pesa</option>
                            <option value="airtel">Airtel Money</option>
                            <option value="orange">Orange Money</option>
                        </select>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-7">
                            <label class="form-label">Montant</label>
                            <input type="number" step="0.01" min="1" name="montant" id="montant" class="form-control" required>
                            <div class="aide-fichier mt-1">Le montant est impose par la demande d'adoption lorsqu'elle est selectionnee.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Devise</label>
                            <select name="devise" class="form-select">
                                <option value="USD">USD</option>
                                <option value="CDF">CDF</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 mb-3">
                        <label class="form-label">Numero de telephone</label>
                        <input type="text" name="numero_telephone" class="form-control" placeholder="2439xxxxxxxx" required>
                    </div>

                    <button class="btn btn-success">Initier</button>
                </form>
            </section>
        </div>

        <div class="col-lg-7">
            <section class="panneau p-3 p-lg-4">
                <h5 class="mb-1">Historique des transactions</h5>
                <p class="text-muted small mb-3">Consultez les references, statuts et justificatifs de paiement.</p>

                <div class="table-responsive">
                    <table class="table table-sm align-middle table-historique">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Demande</th>
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
                                        <div class="small fw-semibold">{{ $payment->reference_interne }}</div>
                                        <div class="small text-muted">{{ $payment->created_at?->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        @if($payment->demandeAdoption)
                                            <div class="small fw-semibold">Demande #{{ $payment->demandeAdoption->id }}</div>
                                            <div class="small text-muted">{{ $payment->demandeAdoption->animal?->nom ?? 'Animal' }}</div>
                                            <div class="small text-muted">Statut demande: {{ $payment->demandeAdoption->statut }}</div>
                                        @else
                                            <div class="small text-muted">Paiement libre sans demande liée.</div>
                                        @endif
                                    </td>
                                    <td>{{ strtoupper($payment->fournisseur) }}</td>
                                    <td>
                                        <div class="small fw-semibold">{{ number_format((float) $payment->montant, 2, ',', ' ') }} {{ $payment->devise }}</div>
                                        @if($payment->demandeAdoption)
                                            <div class="small text-muted">
                                                Montant attendu: {{ number_format((float) ($payment->demandeAdoption->animal?->prix_adoption ?? $payment->montant), 2, ',', ' ') }} $
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->statut === 'reussi')
                                            <span class="pastille-statut statut-reussi">Reussi</span>
                                            <div class="small text-success mt-1">Paiement effectue</div>
                                        @elseif($payment->statut === 'echoue')
                                            <span class="pastille-statut statut-echoue">Echoue</span>
                                        @else
                                            <span class="pastille-statut statut-attente">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if($payment->statut === 'en_attente')
                                                <form method="POST" action="{{ route('payments.confirm', $payment) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-primary">Confirmer statut</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('payments.pdf', $payment) }}" class="btn btn-sm btn-outline-secondary">Telecharger PDF</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="ligne-vide">Aucune transaction pour le moment.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payments->hasPages())
                    @php
                        $current = $payments->currentPage();
                        $last = $payments->lastPage();
                        $start = max(1, $current - 1);
                        $end = min($last, $current + 1);
                    @endphp
                    <div class="pagination-coquille">
                        <div class="pagination-info">Page {{ $current }} sur {{ $last }}</div>
                        <div class="pagination-actions">
                            @if($payments->onFirstPage())
                                <span class="btn btn-outline-secondary btn-pagination disabled" aria-disabled="true">Precedent</span>
                            @else
                                <a href="{{ $payments->previousPageUrl() }}" class="btn btn-outline-secondary btn-pagination">Precedent</a>
                            @endif

                            <div class="pagination-pages" aria-label="Pagination paiements">
                                @if($start > 1)
                                    <a href="{{ $payments->url(1) }}" class="pagination-page">1</a>
                                    @if($start > 2)
                                        <span class="pagination-points">...</span>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    <a href="{{ $payments->url($page) }}" class="pagination-page {{ $page === $current ? 'active' : '' }}">{{ $page }}</a>
                                @endfor

                                @if($end < $last)
                                    @if($end < $last - 1)
                                        <span class="pagination-points">...</span>
                                    @endif
                                    <a href="{{ $payments->url($last) }}" class="pagination-page">{{ $last }}</a>
                                @endif
                            </div>

                            @if($payments->hasMorePages())
                                <a href="{{ $payments->nextPageUrl() }}" class="btn btn-success btn-pagination">Suivant</a>
                            @else
                                <span class="btn btn-success btn-pagination disabled" aria-disabled="true">Suivant</span>
                            @endif
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-largeur]').forEach((segmentGraphique) => {
        const largeurBrute = Number(segmentGraphique.getAttribute('data-largeur') || 0);
        const largeurSecurisee = Math.max(0, Math.min(100, largeurBrute));
        segmentGraphique.style.width = `${largeurSecurisee}%`;
    });

    const demandeSelect = document.getElementById('demande_adoption_id');
    const montantInput = document.getElementById('montant');

    const mettreAJourMontant = () => {
        if (!demandeSelect || !montantInput) {
            return;
        }

        const option = demandeSelect.selectedOptions?.[0];
        const montantFixe = option?.dataset?.montant;

        if (montantFixe) {
            montantInput.value = montantFixe;
            montantInput.readOnly = true;
            montantInput.classList.add('bg-light');
        } else {
            montantInput.readOnly = false;
            montantInput.classList.remove('bg-light');
        }
    };

    demandeSelect?.addEventListener('change', mettreAJourMontant);
    mettreAJourMontant();
</script>
@endsection
