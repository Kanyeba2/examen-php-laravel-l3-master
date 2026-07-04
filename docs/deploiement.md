# Deploiement (Point 20)

Ce document couvre le point **20. Deploiement** du cahier de charge:

- Application deployee en ligne
- `.env.example` complet
- Base de donnees de production configuree

## Recommandation

Pour ce projet Laravel (auth, paiements, mails, queue), **Railway** est la voie la plus simple et stable.

- **Railway**: deploiement Laravel + DB Postgres/MySQL tres rapide.
- **Heroku**: possible et robuste, mais setup add-ons/buildpacks plus manuel.
- **Vercel**: possible pour API/serverless, **moins adapte** a ce projet complet (sessions/queue/workers persistants).

## 1. Variables d environnement requises

Utiliser `.env.example` comme base. En production, definir au minimum:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY=...` (generee)
- `APP_URL=https://votre-domaine`
- `DB_CONNECTION=pgsql` (ou `mysql`)
- `DB_URL=...` (chaine fournie par Railway/Heroku)
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`
- `MAIL_MAILER=smtp`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_SCHEME`
- `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
- `LABPAY_ENABLED`, `LABPAY_BASE_URL`, `LABPAY_TOKEN` (si paiement actif)

## 2. Deploiement sur Railway (recommande)

1. Pousser le projet sur GitHub.
2. Creer un projet Railway et connecter le repo.
3. Ajouter un service **PostgreSQL** (ou MySQL) dans Railway.
4. Dans Variables Railway, definir toutes les variables de la section ci-dessus.
5. Definir la commande build/deploy par defaut (Nixpacks gere `composer install`).
6. Lancer les commandes post-deploiement:

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize
```

7. Verifier la page `/` et la connexion utilisateur.

### Worker queue Railway

Si `QUEUE_CONNECTION=database`, creer un **deuxieme service worker** avec commande:

```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

## 3. Deploiement Heroku (alternative)

Le projet inclut un `Procfile`:

- `web: heroku-php-apache2 public/`
- `release: php artisan migrate --force`
- `worker: php artisan queue:work ...`

Etapes:

1. Creer app Heroku.
2. Ajouter buildpack PHP.
3. Ajouter base Postgres (`heroku addons:create heroku-postgresql`).
4. Configurer variables (`APP_KEY`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, mail, LabPay...).
5. Deploy (`git push heroku main`).
6. Si besoin seed:

```bash
heroku run php artisan db:seed --force
```

## 4. Vercel (analyse)

Vercel est excellent pour frontend/serverless, mais pour cette application Laravel complete:

- sessions serveur,
- jobs/queue,
- traitements asynchrones,
- paiements + callbacks,

la maintenance sera plus complexe. **Non recommande comme choix principal** ici.

## 5. Checklist de validation finale (Point 20)

- [ ] URL publique accessible
- [ ] Login/roles fonctionnels
- [ ] Base production connectee (migrations appliquees)
- [ ] Envoi d email OK
- [ ] Queue worker en cours (si queue async)
- [ ] Paiement mobile et callback verifies
- [ ] `.env.example` complet et propre dans le repo

## 6. Commandes utiles de diagnostic

```bash
php artisan about
php artisan route:list
php artisan migrate:status
php artisan tinker --execute="echo config('database.default').PHP_EOL;"
php artisan tinker --execute="echo config('queue.default').PHP_EOL;"
php artisan tinker --execute="echo config('mail.default').PHP_EOL;"
```

## 7. Plan B immediat: basculer vers Render

Si Railway echoue au deploy source, basculer sur Render est souvent plus direct pour Laravel complet.

Le projet inclut deja le blueprint Render: [render.yaml](../render.yaml)

### Etapes exactes (Render)

1. Ouvrir Render et se connecter avec GitHub.
2. Choisir **New +** puis **Blueprint**.
3. Selectionner le repo `Kanyeba2/examen-php-laravel-l3-master`.
4. Render detecte automatiquement [render.yaml](../render.yaml) et propose:
	- 1 service web PHP
	- 1 worker queue
	- 1 base PostgreSQL
5. Lancer la creation.
6. Quand les services sont crees, ouvrir le service web et definir les variables `sync: false`:
	- `APP_KEY`
	- `APP_URL`
	- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
	- `LABPAY_TOKEN` (si paiement actif)
7. Ouvrir le Shell du service web et executer:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize
```

8. Tester l URL publique du service web.

### Verification rapide

```bash
php artisan route:list
php artisan migrate:status
php artisan tinker --execute="echo config('database.default').PHP_EOL;"
php artisan tinker --execute="echo config('queue.default').PHP_EOL;"
```

## 8. Vercel (si vous voulez quand meme tester)

Le projet inclut [vercel.json](../vercel.json) pour un test rapide, mais cette option reste moins adaptee a ce projet (sessions serveur + worker queue + callbacks paiements).

Si vous testez Vercel:

1. Importer le repo dans Vercel.
2. Definir les variables d environnement comme en production.
3. Utiliser une base externe (Postgres) et eviter les jobs critiques en asynchrone tant que le worker n est pas externalise.
