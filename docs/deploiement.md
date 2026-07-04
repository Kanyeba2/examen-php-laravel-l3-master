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
