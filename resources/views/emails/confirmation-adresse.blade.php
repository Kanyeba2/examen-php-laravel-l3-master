<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation d'adresse email</title>
</head>
<body>
    <h1>Confirmation de votre adresse email</h1>
    <p>Bonjour {{ $utilisateur->nom }},</p>
    <p>Merci pour votre inscription. Veuillez utiliser ce code pour confirmer votre adresse email :</p>
    <p><strong style="font-size: 24px; letter-spacing: 2px;">{{ $code }}</strong></p>
    <p>Ce code expire bientot. Si vous n'etes pas a l'origine de cette inscription, ignorez ce message.</p>
    <p>Cordialement,<br>L'equipe Adopte un ami</p>
</body>
</html>
