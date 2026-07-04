<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recu Paiement {{ $payment->reference_interne }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        .header { margin-bottom: 18px; }
        .title { font-size: 20px; font-weight: bold; margin: 0 0 6px 0; }
        .subtitle { font-size: 13px; color: #374151; margin: 0 0 4px 0; }
        .muted { color: #6b7280; }
        .box { border: 1px solid #d1d5db; border-radius: 6px; padding: 12px; margin-bottom: 12px; }
        .highlight { border: 1px solid #86efac; background: #f0fdf4; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 6px 0; vertical-align: top; }
        .label { width: 45%; color: #374151; font-weight: bold; }
        .status { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 11px; }
        .status-success { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 22px; font-size: 11px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">Recu de paiement mobile</p>
        <p class="muted">Reference: {{ $payment->reference_interne }}</p>
        <p class="subtitle">Facture de paiement de l'adoption</p>
    </div>

    <div class="box highlight">
        <table>
            <tr>
                <td class="label">Etat du document</td>
                <td>
                    @if($payment->statut === 'reussi')
                        <span class="status status-success">Paiement acquitte</span>
                    @elseif($payment->statut === 'echoue')
                        <span class="status status-failed">Paiement echoue</span>
                    @else
                        <span class="status status-pending">Paiement en attente</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="box">
        <table>
            <tr>
                <td class="label">Client</td>
                <td>{{ $payment->utilisateur->nom ?? 'Client' }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $payment->utilisateur->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Telephone client</td>
                <td>{{ $payment->utilisateur->telephone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Fournisseur</td>
                <td>{{ strtoupper($payment->fournisseur) }}</td>
            </tr>
            <tr>
                <td class="label">Numero telephone</td>
                <td>{{ $payment->numero_telephone }}</td>
            </tr>
            <tr>
                <td class="label">Montant</td>
                <td>{{ number_format((float) $payment->montant, 2, ',', ' ') }} {{ $payment->devise }}</td>
            </tr>
            @if($payment->demandeAdoption)
            <tr>
                <td class="label">Demande adoption</td>
                <td>#{{ $payment->demandeAdoption->id }}</td>
            </tr>
            <tr>
                <td class="label">Animal concerne</td>
                <td>{{ $payment->demandeAdoption->animal?->nom ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Montant attendu</td>
                <td>{{ number_format((float) ($payment->demandeAdoption->animal?->prix_adoption ?? $payment->montant), 2, ',', ' ') }} $</td>
            </tr>
            <tr>
                <td class="label">Statut de la demande</td>
                <td>{{ $payment->demandeAdoption->statut }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Reference fournisseur</td>
                <td>{{ $payment->reference_fournisseur ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Statut</td>
                <td>
                    @if($payment->statut === 'reussi')
                        <span class="status status-success">Reussi</span>
                    @elseif($payment->statut === 'echoue')
                        <span class="status status-failed">Echoue</span>
                    @else
                        <span class="status status-pending">En attente</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Date transaction</td>
                <td>{{ $payment->updated_at?->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="box">
        <table>
            <tr>
                <td class="label">Resume facture</td>
                <td>Cette facture confirme le paiement lie a la demande d'adoption et peut etre presentee comme justificatif.</td>
            </tr>
        </table>
    </div>

    <p class="footer">Document genere automatiquement par Adopte un ami.</p>
</body>
</html>
