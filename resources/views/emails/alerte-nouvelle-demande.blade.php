<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Alerte nouvelle demande</title>
</head>
<body>
    <h1>Nouvelle demande d'adoption</h1>
    <p>Une nouvelle demande vient d'etre soumise.</p>
    <ul>
        <li>Client : {{ $demande->utilisateur->nom ?? 'N/A' }} ({{ $demande->utilisateur->email ?? 'N/A' }})</li>
        <li>Animal : {{ $demande->animal->nom ?? 'N/A' }}</li>
        <li>Statut : {{ $demande->statut }}</li>
    </ul>
    <p>Merci de traiter cette demande depuis le dashboard administrateur/manager.</p>
</body>
</html>
