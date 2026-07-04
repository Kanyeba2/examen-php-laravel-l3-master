$root = (Get-Location).Path
$out = 'explication_fonctions_complet.md'

$exclude = '\\vendor\\|\\node_modules\\|\\storage\\|\\bootstrap\\cache\\|\\public\\storage\\|\\.git\\|composer-install-.*\\.log$|ChatGPT Image|\\.env$|composer\\.phar$|composer-setup\\.php$|cacert\\.pem$|database\\database\\.sqlite$'

$allowedExtensions = @('.php', '.blade.php', '.js', '.css', '.json', '.md', '.xml', '.yml', '.yaml', '.txt', '.htaccess', '.editorconfig', '.gitignore', '.gitattributes', '.npmrc')

$files = Get-ChildItem -Recurse -File |
    Where-Object { $_.FullName -notmatch $exclude } |
    Sort-Object FullName

function Get-RoleText([string]$rel) {
    if ($rel -like 'app/Http/Controllers/*') { return 'Controle les requetes HTTP, la logique metier et la reponse finale.' }
    if ($rel -like 'app/Models/*') { return 'Definit les entites metier, relations et transformations de donnees.' }
    if ($rel -like 'app/Http/Requests/*') { return 'Valide les entrees utilisateur avant traitement dans les controleurs.' }
    if ($rel -like 'app/Http/Middleware/*') { return 'Filtre les requetes (acces, role, etat compte, limitations).' }
    if ($rel -like 'app/Services/*') { return 'Centralise une logique metier reutilisable ou integration externe.' }
    if ($rel -like 'app/Events/*') { return 'Declare un evenement metier declenche par une action importante.' }
    if ($rel -like 'app/Listeners/*') { return 'Ecoute un evenement et execute une reaction associee.' }
    if ($rel -like 'app/Mail/*') { return 'Construit un email metier (sujet, vue, donnees envoyees).' }
    if ($rel -like 'app/Notifications/*') { return 'Construit des notifications base/mail envoyees aux utilisateurs.' }
    if ($rel -like 'resources/views/*') { return 'Construit l interface utilisateur Blade (HTML + directives serveur).' }
    if ($rel -like 'routes/*') { return 'Definit les routes, middleware et points d entree web/api/console.' }
    if ($rel -like 'database/migrations/*') { return 'Definit l evolution du schema SQL versionnee dans le temps.' }
    if ($rel -like 'database/seeders/*') { return 'Prepare des donnees de demo/test rejouables.' }
    if ($rel -like 'database/factories/*') { return 'Genere des donnees factices pour tests.' }
    if ($rel -like 'config/*') { return 'Configure le comportement global de l application Laravel.' }
    if ($rel -like 'bootstrap/*') { return 'Initialise le cycle de vie de l application au demarrage.' }
    if ($rel -like 'tests/*') { return 'Verifie automatiquement le comportement attendu du projet.' }
    return 'Fichier de support (documentation, outillage, build, qualite, assets).'
}

function Describe-Function([string]$name, [string]$file) {
    $n = $name.ToLowerInvariant()
    if ($file -like 'database/migrations/*' -and $n -eq 'up') { return 'Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.' }
    if ($file -like 'database/migrations/*' -and $n -eq 'down') { return 'Annule la migration: retire les structures ajoutees par up().' }
    if ($file -like 'database/seeders/*' -and $n -eq 'run') { return 'Insere les donnees de depart (roles, users, animaux, demandes, etc.).' }
    if ($n -eq 'rules') { return 'Definit les regles de validation des champs recus.' }
    if ($n -eq 'messages') { return 'Personnalise les messages d erreur de validation.' }
    if ($n -eq 'authorize') { return 'Autorise ou bloque la requete avant validation/traitement.' }
    if ($n -eq 'index') { return 'Affiche une liste de ressources avec eventuels filtres et pagination.' }
    if ($n -eq 'create') { return 'Affiche le formulaire de creation d une ressource.' }
    if ($n -eq 'store') { return 'Valide puis enregistre une nouvelle ressource en base.' }
    if ($n -eq 'show') { return 'Affiche le detail d une ressource precise.' }
    if ($n -eq 'edit') { return 'Affiche le formulaire de modification d une ressource.' }
    if ($n -eq 'update') { return 'Valide puis met a jour une ressource existante.' }
    if ($n -eq 'destroy') { return 'Supprime une ressource et gere les effets associes.' }
    if ($n -eq 'handle') { return 'Intercepte la requete et applique une regle transversale.' }
    if ($n -eq 'boot') { return 'Configure des comportements globaux au demarrage du service provider.' }
    if ($n -eq 'register') { return 'Enregistre des services/bindings dans le conteneur Laravel.' }
    if ($n -eq 'toarray') { return 'Transforme l objet en tableau pour serialisation/transport.' }
    if ($n -eq 'via') { return 'Definit les canaux de notification (database, mail, etc.).' }
    if ($n -eq 'tomail') { return 'Construit le contenu de la notification email.' }
    if ($n -eq 'pdf') { return 'Genere ou retourne un document PDF pour la ressource.' }
    if ($n -eq 'confirm' -or $n -eq 'confirmation') { return 'Valide et confirme une action sensible (paiement, verification, etc.).' }
    if ($n -eq 'callback') { return 'Traite un retour asynchrone provenant d un service externe.' }
    if ($n -eq 'manager' -or $n -eq 'admin' -or $n -eq 'client') { return 'Construit les donnees du tableau de bord pour ce role utilisateur.' }
    if ($n -eq 'login' -or $n -eq 'logout' -or $n -eq 'registeruser') { return 'Gere une etape du cycle d authentification utilisateur.' }
    if ($n -like 'is*' -or $n -like 'has*' -or $n -like 'can*') { return 'Retourne une condition booleenne liee aux droits ou etats metier.' }
    if ($n -like 'get*') { return 'Recupere une information ciblee a partir des donnees metier.' }
    if ($n -like 'set*') { return 'Ajuste une valeur/etat interne avant persistence ou rendu.' }
    return 'Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.'
}

function Get-FunctionRows([string]$rel, [string[]]$lines) {
    $rows = New-Object System.Collections.Generic.List[string]

    $phpRegexes = @(
        '^\s*(public|protected|private)?\s*(static\s+)?function\s+([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)',
        '^\s*function\s+([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)'
    )

    $jsRegexes = @(
        '^\s*function\s+([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)',
        '^\s*(const|let|var)\s+([A-Za-z_][A-Za-z0-9_]*)\s*=\s*\(([^)]*)\)\s*=>',
        '^\s*([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)\s*\{\s*$'
    )

    for ($i = 0; $i -lt $lines.Count; $i++) {
        $line = $lines[$i]
        $trim = $line.Trim()

        if ($trim.StartsWith('//') -or $trim.StartsWith('*') -or $trim.StartsWith('#')) { continue }

        $matched = $false

        if ($rel.EndsWith('.php') -or $rel.EndsWith('.blade.php')) {
            foreach ($rx in $phpRegexes) {
                $m = [regex]::Match($line, $rx)
                if ($m.Success) {
                    $name = $m.Groups[3].Value
                    $params = $m.Groups[4].Value
                    if ([string]::IsNullOrWhiteSpace($name)) {
                        $name = $m.Groups[1].Value
                        $params = $m.Groups[2].Value
                    }
                    if (-not [string]::IsNullOrWhiteSpace($name)) {
                        $desc = Describe-Function $name $rel
                        $rows.Add('- Ligne ' + ($i + 1) + ': ' + $name + '(' + $params + ') -> ' + $desc)
                        $matched = $true
                        break
                    }
                }
            }
        }

        if (-not $matched -and $rel.EndsWith('.js')) {
            foreach ($rx in $jsRegexes) {
                $m = [regex]::Match($line, $rx)
                if ($m.Success) {
                    $name = $m.Groups[1].Value
                    $params = $m.Groups[2].Value
                    if ($rx -like '*const|let|var*') {
                        $name = $m.Groups[2].Value
                        $params = $m.Groups[3].Value
                    }
                    if (-not [string]::IsNullOrWhiteSpace($name)) {
                        $desc = Describe-Function $name $rel
                        $rows.Add('- Ligne ' + ($i + 1) + ': ' + $name + '(' + $params + ') -> ' + $desc)
                        $matched = $true
                        break
                    }
                }
            }
        }
    }

    return $rows
}

function Get-BlockSummary([string]$rel, [string[]]$lines) {
    if ($rel -like 'resources/views/*.blade.php' -or $rel -like 'resources/views/*/*.blade.php' -or $rel -like 'resources/views/*/*/*.blade.php') {
        $ifCount = ($lines | Select-String -Pattern '@if|@elseif|@unless' -SimpleMatch:$false).Count
        $loopCount = ($lines | Select-String -Pattern '@foreach|@for|@while|@forelse' -SimpleMatch:$false).Count
        $incCount = ($lines | Select-String -Pattern '@include|@extends|@section|@yield' -SimpleMatch:$false).Count
        $formCount = ($lines | Select-String -Pattern '@csrf|method\(|name="|<form' -SimpleMatch:$false).Count
        return 'Template Blade sans declaration de fonctions. Blocs dominants: conditions=' + $ifCount + ', boucles=' + $loopCount + ', composition=' + $incCount + ', formulaires=' + $formCount + '.'
    }

    if ($rel -like 'routes/*.php') {
        $rCount = ($lines | Select-String -Pattern 'Route::get|Route::post|Route::put|Route::patch|Route::delete|Route::middleware|Route::prefix|Route::name' -SimpleMatch:$false).Count
        return 'Fichier de routes sans fonctions metier principales. Nombre de declarations Route::* detectees: ' + $rCount + '.'
    }

    if ($rel -like 'config/*.php') {
        $keyMatches = ($lines | Select-String -Pattern "'([a-zA-Z0-9_\-]+)'\s*=>" -AllMatches)
        $keys = New-Object System.Collections.Generic.List[string]
        foreach ($km in $keyMatches) {
            foreach ($mm in $km.Matches) {
                if ($keys.Count -ge 8) { break }
                $k = $mm.Groups[1].Value
                if (-not $keys.Contains($k)) { $keys.Add($k) }
            }
            if ($keys.Count -ge 8) { break }
        }
        if ($keys.Count -eq 0) { return 'Fichier de configuration sans fonctions; contient des options globales.' }
        return 'Fichier de configuration sans fonctions. Cles importantes (extrait): ' + ($keys -join ', ') + '.'
    }

    if ($rel -like '*.json') {
        return 'Fichier JSON declaratif (pas de fonctions). Il definit des options/outillage/dependances.'
    }

    if ($rel -like '*.md') {
        return 'Fichier de documentation (pas de fonctions executables).'
    }

    if ($rel -like '*.css') {
        $selCount = ($lines | Select-String -Pattern '\{|\.' -SimpleMatch:$false).Count
        return 'Feuille de style (pas de fonctions). Blocs CSS detectes approximativement: ' + $selCount + '.'
    }

    return 'Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.'
}

$content = New-Object System.Collections.Generic.List[string]
$content.Add('# Explication Fonction Par Fonction Et Bloc Par Bloc')
$content.Add('')
$content.Add('## Objectif')
$content.Add('- Expliquer ce que fait chaque fonction/methode detectee dans chaque fichier.')
$content.Add('- Quand un fichier ne contient pas de fonction, expliquer les blocs de code dominants.')
$content.Add('- Couvrir tous les fichiers applicatifs du projet (hors dependances et artefacts).')
$content.Add('')
$content.Add('## Regles D Analyse')
$content.Add('1. Detection automatique des fonctions PHP/JS (nom, ligne, parametres).')
$content.Add('2. Resume du role du fichier selon son dossier (controller, model, view, etc.).')
$content.Add('3. Resume des blocs pour les fichiers sans fonctions (Blade, routes, config, json, css, md).')
$content.Add('4. Descriptions heuristiques basees sur les conventions Laravel et les noms de methodes.')
$content.Add('')

foreach ($f in $files) {
    $rel = $f.FullName.Substring($root.Length + 1) -replace '\\', '/'

    $ok = $false
    foreach ($ext in $allowedExtensions) {
        if ($rel.EndsWith($ext)) { $ok = $true; break }
    }

    if (-not $ok) {
        if ($rel -eq '.editorconfig' -or $rel -eq '.gitignore' -or $rel -eq '.gitattributes' -or $rel -eq '.npmrc' -or $rel -eq 'artisan') {
            $ok = $true
        }
    }

    if (-not $ok) { continue }

    if ($rel -eq $out) { continue }

    try {
        $lines = Get-Content -Path $f.FullName -Encoding UTF8
    } catch {
        try {
            $lines = Get-Content -Path $f.FullName
        } catch {
            $content.Add('### ' + $rel)
            $content.Add('- Role global: ' + (Get-RoleText $rel))
            $content.Add('- Analyse: Impossible de lire le contenu automatiquement (encodage ou binaire).')
            $content.Add('')
            continue
        }
    }

    $content.Add('### ' + $rel)
    $content.Add('- Role global: ' + (Get-RoleText $rel))

    $fnRows = Get-FunctionRows $rel $lines

    if ($fnRows.Count -gt 0) {
        $content.Add('- Fonctions/methodes detectees: ' + $fnRows.Count)
        foreach ($r in $fnRows) { $content.Add($r) }
    } else {
        $content.Add('- Fonctions/methodes detectees: 0')
        $content.Add('- Blocs dominants: ' + (Get-BlockSummary $rel $lines))
    }

    $content.Add('')
}

$content.Add('## Limites De Cette Version')
$content.Add('- Cette version est automatique: elle couvre tout le projet vite, mais reste heuristique.')
$content.Add('- Pour les fichiers critiques, une analyse manuelle methode par methode peut encore enrichir les details.')

Set-Content -Path $out -Value $content -Encoding UTF8
