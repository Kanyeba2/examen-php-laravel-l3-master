# Lancement local de l'application (Windows)

Ce document regroupe toutes les commandes utiles pour lancer l'application Laravel en local et diagnostiquer les pannes courantes.

## 1) Se placer dans le dossier du projet

```powershell
cd /d C:\xampp\htdocs\examen-php-laravel-l3-master
```

Explication:
- Ouvre le bon dossier avant d'executer Composer/Artisan.

## 2) Verifier PHP

```powershell
C:\php84\php.exe -v
```

Explication:
- Confirme que le binaire PHP 8.4 est bien disponible.
- Si cette commande echoue, Laravel ne pourra pas demarrer.

## 3) Installer/Reparer les dependances PHP (vendor)

```powershell
C:\php84\php.exe composer.phar install --no-interaction --prefer-dist
```

Explication:
- Installe les dependances depuis `composer.lock`.
- A utiliser aussi si `vendor` est incomplet/corrompu.

## 4) Verifier le fichier .env (important)

Dans `.env`, garder une seule ligne `APP_URL`:

```dotenv
APP_URL=http://localhost
```

Explication:
- Ne pas laisser deux lignes `APP_URL`.
- La derniere ligne ecrase la precedente et peut provoquer des comportements inattendus.

## 5) Generer la cle applicative (si necessaire)

```powershell
C:\php84\php.exe artisan key:generate
```

Explication:
- Cree/met a jour `APP_KEY` dans `.env`.
- A faire au moins une fois sur une nouvelle installation.

## 6) Nettoyer les caches Laravel apres changement de config

```powershell
C:\php84\php.exe artisan optimize:clear
```

Explication:
- Vide les caches config/routes/views/events.
- Recommande apres toute modification de `.env`.

## 7) Preparer la base SQLite locale

```powershell
C:\php84\php.exe -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
C:\php84\php.exe artisan migrate --seed
```

Explication:
- Cree le fichier SQLite s'il n'existe pas.
- Applique les migrations et injecte les donnees de test.

## 8) Lancer le serveur Laravel local

```powershell
C:\php84\php.exe artisan serve --host=127.0.0.1 --port=8000
```

Puis ouvrir:
- http://127.0.0.1:8000
- ou http://localhost:8000

Explication:
- Garde ce terminal ouvert pendant l'utilisation de l'application.
- Arret du serveur: `Ctrl + C`.

## 9) Optionnel: lancer le worker de queue

```powershell
C:\php84\php.exe artisan queue:work --tries=1 --timeout=90
```

Explication:
- Utile seulement si `QUEUE_CONNECTION=database`.
- Si `QUEUE_CONNECTION=sync`, cette commande n'est pas necessaire.

## 10) Optionnel: assets frontend en mode dev (Vite)

```powershell
npm install
npm run dev
```

Explication:
- Necessaire si tu modifies JS/CSS et veux le rechargement automatique.
- A lancer dans un second terminal.

## 11) Diagnostic si le navigateur affiche "connection refused"

Verifier si le port 8000 ecoute:

```powershell
C:\Windows\System32\netstat.exe -ano | findstr :8000
```

Explication:
- Aucune sortie: le serveur n'est pas lance.
- Si un PID apparait, le port est occupe par un processus.

Tuer un processus bloque (exemple PID 12345):

```powershell
taskkill /PID 12345 /F
```

Puis relancer:

```powershell
C:\php84\php.exe artisan serve --host=127.0.0.1 --port=8000
```

## 12) Routine rapide quotidienne (3 commandes)

```powershell
cd /d C:\xampp\htdocs\examen-php-laravel-l3-master
C:\php84\php.exe artisan optimize:clear
C:\php84\php.exe artisan serve --host=127.0.0.1 --port=8000
```

Ensuite ouvre http://127.0.0.1:8000

## 13) Commande unique (tout en une ligne)

```powershell
powershell -NoProfile -Command "Set-Location 'C:\xampp\htdocs\examen-php-laravel-l3-master'; & 'C:\php84\php.exe' composer.phar install --no-interaction --prefer-dist; & 'C:\php84\php.exe' artisan optimize:clear; if (-not (Test-Path 'database/database.sqlite')) { New-Item -ItemType File -Path 'database/database.sqlite' | Out-Null }; & 'C:\php84\php.exe' artisan migrate --seed; & 'C:\php84\php.exe' -S 127.0.0.1:8000 'C:\xampp\htdocs\examen-php-laravel-l3-master\server.php'"
```

Explication:
- Cette ligne execute toutes les etapes de demarrage en sequence.
- La commande se termine sur le serveur PHP integre (`php -S`), donc le terminal reste ouvert tant que le serveur tourne.
- Arret du serveur: `Ctrl + C`.

## 14) Methode la plus simple (script local)

```powershell
C:\xampp\htdocs\examen-php-laravel-l3-master\start-local.cmd
```

Explication:
- Lance les nettoyages Laravel puis ouvre une fenetre serveur persistante sur `http://127.0.0.1:8000`.
- C'est la methode recommandee sous Windows pour eviter les fermetures immediates du serveur.

## Notes utiles

- Les fichiers de deploiement (Docker/Render/Vercel) n'empechent pas le lancement local tant que tu demarres avec `artisan serve`.
- Si `artisan serve` tombe avec une erreur de fichier interne manquant, verifie les dependances avec la commande Composer (section 3).
