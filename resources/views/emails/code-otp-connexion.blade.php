<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Code OTP de connexion</title>
</head>
<body>
    <h1>Verification de connexion</h1>
    <p>Bonjour {{ $utilisateur->nom }},</p>
    <p>Utilisez ce code OTP pour finaliser votre connexion :</p>
    <p><strong style="font-size: 24px; letter-spacing: 2px;">{{ $code }}</strong></p>
    <p>Ce code expire dans 10 minutes.</p>
    <p>Si vous n'etes pas a l'origine de cette tentative, changez votre mot de passe immediatement.</p>
</body>
</html>
