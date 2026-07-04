<h2>Recu de paiement mobile</h2>

<p>Bonjour {{ $payment->utilisateur->nom ?? 'Client' }},</p>

<p>Votre paiement a ete confirme avec succes.</p>

<ul>
    <li><strong>Reference interne:</strong> {{ $payment->reference_interne }}</li>
    <li><strong>Reference fournisseur:</strong> {{ $payment->reference_fournisseur ?? 'N/A' }}</li>
    <li><strong>Fournisseur:</strong> {{ strtoupper($payment->fournisseur) }}</li>
    <li><strong>Montant:</strong> {{ number_format((float) $payment->montant, 2, ',', ' ') }} {{ $payment->devise }}</li>
    <li><strong>Statut:</strong> {{ $payment->statut }}</li>
    <li><strong>Date:</strong> {{ $payment->updated_at?->format('d/m/Y H:i') }}</li>
</ul>

@if($payment->demandeAdoption)
<p>
    Cette transaction est liee a la demande d'adoption #{{ $payment->demandeAdoption->id }}
    @if($payment->demandeAdoption->animal)
        ({{ $payment->demandeAdoption->animal->nom }}).
    @endif
</p>
@endif

<p>Merci pour votre confiance.</p>
