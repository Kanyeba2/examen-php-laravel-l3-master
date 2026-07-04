<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notification de statut</title>
</head>
<body>
    <h1>Mise a jour de votre demande d'adoption</h1>
    <p>Bonjour {{ $demande->utilisateur->nom ?? 'utilisateur' }},</p>
    <p>Le statut de votre demande pour <strong>{{ $demande->animal->nom ?? 'cet animal' }}</strong> a ete modifie.</p>
    <p>Nouveau statut : <strong>{{ $demande->statut }}</strong></p>
    <p>Connectez-vous a votre espace pour consulter les details.</p>
    <p>Cordialement,<br>L'equipe Adopte un ami</p>
</body>
</html>
