<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation d'action importante</title>
</head>
<body>
    <h1>Votre demande a bien ete enregistree</h1>
    <p>Bonjour {{ $demande->utilisateur->nom ?? 'utilisateur' }},</p>
    <p>Nous confirmons la reception de votre demande d'adoption pour <strong>{{ $demande->animal->nom ?? 'cet animal' }}</strong>.</p>
    <p>Statut actuel : <strong>{{ $demande->statut }}</strong></p>
    <p>Message envoye :</p>
    <blockquote>{{ $demande->message }}</blockquote>
    <p>Notre equipe reviendra vers vous sous peu.</p>
    <p>Cordialement,<br>L'equipe Adopte un ami</p>
</body>
</html>
