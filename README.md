# README — Examen Final Laravel

### Faculté des Sciences Informatiques (FASI) — Université Protestant du Congo (UPC)

### Promotion L3 · Année académique 2025–2026

---

## Objectif du projet

Concevoir et développer une application web complète avec **Laravel**, en respectant les bonnes pratiques du développement moderne. Le projet doit démontrer la maîtrise des concepts fondamentaux et avancés vus en cours, tout en répondant à un besoin réel et concret.

---

## Structure attendue du dépôt

```
nom-du-projet/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Mail/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── lang/
├── routes/
│   ├── web.php
│   └── api.php
├── .env.example
├── README.md
└── ...
```

---

## Exigences techniques

Les exigences sont classées en **3 niveaux** : Fondamentaux, Intermédiaires, et Avancés.

---

### Niveau 1 — Fondamentaux *(obligatoires)*

#### 1. Architecture MVC & Structure du projet

- Respect strict de l'architecture MVC (Models, Views, Controllers)
- Code organisé, lisible et commenté
- Utilisation des conventions de nommage Laravel

#### 2. Base de données & Migrations

- Toutes les tables créées via des **migrations** (aucune table créée manuellement)
- Utilisation des **relations Eloquent** (hasMany, belongsTo, belongsToMany, etc.)
- **Seeders** pour peupler la base de données avec des données de test réalistes
- Respect de la normalisation des données (pas de redondance inutile)

#### 3. Opérations CRUD complètes

- Au moins **une entité principale** avec les 4 opérations (Create, Read, Update, Delete)
- Pagination des listes (`paginate()`)
- Recherche et filtrage des données

#### 4. Routage & Contrôleurs

- Utilisation des **Resource Controllers** (`Route::resource`)
- Séparation claire des routes web et API
- Routes nommées (`route('nom.action')`)

#### 5. Vues Blade

- Utilisation des **layouts Blade** (`@extends`, `@section`, `@yield`)
- Composants réutilisables (`@include`, `@component`)
- Affichage conditionnel selon les rôles (`@can`, `@auth`, `@role`)

#### 6. Validation des formulaires

- Validation via **Requests** dédiés
- Messages d'erreur personnalisés et affichés à l'utilisateur
- Protection **CSRF** sur tous les formulaires (`@csrf`)

---

### Niveau 2 — Intermédiaires *(obligatoires)*

#### 7. Authentification multi-rôles

- Au minimum **3 types d'utilisateurs** avec des rôles distincts, par exemple :
  - `Administrateur` — accès total
  - `Gestionnaire / Agent` — accès métier partiel
  - `Client / Utilisateur` — accès restreint à son propre espace
- Système de rôles implémenté
- Redirection automatique selon le rôle après connexion
- Protection des routes par rôle

#### 8. Middleware personnalisés

- Au moins **3 middleware** créés manuellement (ex: `CheckRole`, `CheckAccountActive`, `RateLimited`)
- Middleware appliqué aux routes ou groupes de routes concernés
- Explication claire du rôle de chaque middleware dans le README

#### 9. Dashboard Administrateur

- Tableau de bord dédié à l'administrateur avec :
  - **Statistiques globales** (nombre d'utilisateurs, transactions, etc.)
  - **Graphiques** (Chart.js ou autre)
  - **Activité récente** (dernières inscriptions, actions, alertes)
  - Gestion complète des utilisateurs (liste, activation/désactivation, suppression)
  - Gestion des contenus ou entités principales de l'application

#### 10. Mailing (Email)

- Configuration d'un service d'envoi d'email (Mailtrap en dev, SMTP en prod)
- Au moins **4 types d'emails** envoyés automatiquement :
  - Email de bienvenue à l'inscription
  - Email de confirmation d'une action importante (commande, paiement, etc.)
  - Email de confirmation de l'adresse mail après création de compte
  - Email de notification (alerte, changement de statut, etc.)
- Utilisation des **Mailables** et des **templates Blade** pour les emails
- Emails en file d'attente avec **Laravel Queues** (bonus apprécié)

Configuration operationnelle recommandee (pour ne pas bloquer la connexion 2FA):

- Mode local rapide (recommande pour developpement):

```env
MAIL_MAILER=log
QUEUE_CONNECTION=sync
```

Avec ce mode:

- Le code OTP est envoye immediatement.
- En environnement local, le code OTP est aussi affiche dans le message flash de succes (pour se connecter meme si la boite mail n'est pas configuree).
- Les autres emails passent aussi sans worker (execution immediate via `sync`).

- Mode local avec vraie boite de reception (Mailtrap):

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=VOTRE_MAILTRAP_USERNAME
MAIL_PASSWORD=VOTRE_MAILTRAP_PASSWORD
MAIL_FROM_ADDRESS="noreply@adopte-un-ami.test"
MAIL_FROM_NAME="Adopte un ami"
```

Si vous utilisez une queue asynchrone (`QUEUE_CONNECTION=database`), lancer le worker:

```bash
php artisan queue:work
```

Verification rapide de la configuration chargee:

```bash
php artisan tinker --execute="echo 'queue='.config('queue.default').PHP_EOL; echo 'mailer='.config('mail.default').PHP_EOL;"
```

En production, utiliser SMTP + queue asynchrone avec worker en continu (Supervisor/systemd) et ne jamais afficher le code OTP.

#### 11. Double Authentification (2FA)

- Implémentation de la vérification en deux étapes :
  - Envoi d'un **code OTP par email** à la connexion
  - Saisie du code pour valider l'accès
  - Expiration du code après un délai défini (5 à 10 minutes)
- Option d'activation/désactivation du 2FA depuis le profil utilisateur

---

### Niveau 3 — Avancés *(au moins 3 parmi les suivants)*

#### 12. API REST

- Endpoints RESTful documentés et fonctionnels
- Authentification de l'API via **Laravel Sanctum** (tokens)
- Réponses JSON standardisées (code HTTP, message, data)
- Au moins 5 endpoints couvrant les opérations CRUD d'une entité

#### 13. Upload & Gestion de fichiers

- Upload sécurisé de fichiers (images, documents PDF)
- Validation du type et de la taille du fichier
- Stockage organisé dans `storage/app/public`
- Génération de miniatures pour les images (bonus)

#### 14. Notifications

- Utilisation du système de **Notifications Laravel** (`php artisan make:notification`)
- Notifications en base de données (cloche d'alertes dans l'interface)
- Notifications par email déclenchées par des événements métier

#### 15. Événements & Listeners (Facultatif)

- Au moins **1 Event/Listener** implémenté (ex: `UserRegistered`, `PaymentCompleted`)
- Découplage logique entre les actions et leurs conséquences

#### 16. Paiement mobile intégré

- Intégration **une API de paiement mobile** (M-Pesa, Airtel Money, Orange Money)
- Workflow complet : initiation → confirmation → mise à jour du statut
- Historique des transactions avec statuts (en attente, réussi, échoué)
- Reçu de paiement généré automatiquement (PDF ou email)
- Lien de la documentation de LabPay : [https://doc.api.labyrinthe-rdc.com/](https://doc.api.labyrinthe-rdc.com/)

#### 17. Génération de PDF

- Génération dynamique de documents PDF (factures, reçus, rapports, attestations)
- Utilisation d'un package dédié (DomPDF, Snappy, etc.)
- Téléchargement et/ou envoi par email du PDF

#### 18. Recherche avancée & Filtres

- Filtres combinés sur les listes (par date, statut, catégorie, etc.)
- Barre de recherche avec résultats en temps réel (AJAX ou Livewire)

#### 19. Logs & Traçabilité

- Journalisation des actions sensibles (connexions, modifications, suppressions)
- Interface d'administration pour consulter les logs
- Utilisation de `Log::info()`, `Log::warning()` etc. de manière cohérente

#### 20. Déploiement

- Application déployée sur un serveur en ligne (Heroku, Railway, VPS, etc.)
- Fichier `.env.example` fourni avec toutes les variables nécessaires
- Base de données de production configurée

---

## Base de données

- Fournir le **schéma de la base de données** dans le dossier `docs/`
- Toutes les tables doivent avoir des clés étrangères correctement définies
- Les **seeders** doivent permettre de tester l'application immédiatement après installation

### État d'implémentation — Point 2 (Base de données & Migrations)

- [x] Toutes les tables sont créées via migrations Laravel.
  - Migrations principales: `0001_01_01_000000_create_users_table.php`, `2026_06_29_000001_create_animals_table.php`, `2026_06_29_000002_create_adoption_requests_table.php`, `2026_06_29_000003_create_follow_ups_table.php`, `2026_06_29_000004_create_activity_logs_table.php`, `2026_07_03_000005_create_code_verifications_table.php`.
- [x] Relations Eloquent implémentées (`belongsTo`, `hasMany`) entre utilisateurs, animaux, demandes d'adoption, suivis, logs et codes de vérification.
- [x] Seeders réalistes disponibles via `DatabaseSeeder` avec 3 rôles (admin, manager, client), animaux, demandes, suivis et journal d'activités.
- [x] Modèle relationnel normalisé: séparation des entités métier et usage de clés étrangères pour éviter la redondance.

Schéma relationnel (documenté): [docs/schema-base-de-donnees.md](docs/schema-base-de-donnees.md)

### État d'implémentation — Point 3 (Opérations CRUD complètes)

- [x] Entité principale couverte: `Animal`.
  - **Create**: création via `AnimalController@store` et formulaire `animals/create.blade.php`.
  - **Read**: liste et détail via `AnimalController@index` et `AnimalController@show`.
  - **Update**: édition via `AnimalController@edit` et `AnimalController@update`.
  - **Delete**: suppression via `AnimalController@destroy` (boutons disponibles pour manager/admin dans la liste et le détail).
- [x] Pagination active sur la liste des animaux avec `paginate(6)`.
- [x] Recherche et filtrage disponibles sur la liste (`search` par nom/espèce, filtre par `statut`).
- [x] Conservation des paramètres de recherche/filtre entre les pages via `withQueryString()`.

### État d'implémentation — Point 4 (Routage & Contrôleurs)

- [x] Utilisation de **Resource Controllers** avec `Route::resource` pour l'entité `Animal`.
  - Lecture (index/show) dans le groupe authentifié.
  - Écriture (create/store/edit/update/destroy) limitée au groupe `manager,admin`.
- [x] Séparation claire des routes:
  - Web: [routes/web.php](routes/web.php)
  - API: [routes/api.php](routes/api.php)
- [x] Routes nommées utilisées de manière cohérente (`animals.index`, `animals.store`, `adoptions.store`, `login`, `login.attempt`, `register`, `register.store`, etc.).
- [x] Contrôleurs dédiés par contexte:
  - Web: `AnimalController`, `AdoptionRequestController`, `AuthController`, `DashboardController`
  - API: `AnimalApiController`, `DemandeAdoptionApiController`

### État d'implémentation — Point 5 (Vues Blade)

- [x] Utilisation des layouts Blade avec `@extends`, `@section`, `@yield`.
  - Layout principal: [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)
  - Exemples de vues héritées: `animals/index.blade.php`, `auth/login.blade.php`, `dashboard/admin.blade.php`.
- [x] Composants/blocs réutilisables via `@include`.
  - Alertes globales: [resources/views/partials/alerts.blade.php](resources/views/partials/alerts.blade.php)
  - Identité utilisateur navbar: [resources/views/partials/user-identity.blade.php](resources/views/partials/user-identity.blade.php)
- [x] Affichage conditionnel selon rôles/autorisations.
  - `@auth` dans le layout (navigation selon session).
  - `@can('manage-animals')` dans les vues animaux (actions create/edit/delete).
  - Directive personnalisée `@role(...)` / `@elserole(...)` définie dans [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php) et utilisée dans le layout.

### État d'implémentation — Point 6 (Validation des formulaires)

- [x] Validation via **Form Requests** dédiées.
  - Animaux: [app/Http/Requests/StoreAnimalRequest.php](app/Http/Requests/StoreAnimalRequest.php), [app/Http/Requests/UpdateAnimalRequest.php](app/Http/Requests/UpdateAnimalRequest.php)
  - Adoption: [app/Http/Requests/StoreAdoptionRequest.php](app/Http/Requests/StoreAdoptionRequest.php), [app/Http/Requests/UpdateAdoptionStatusRequest.php](app/Http/Requests/UpdateAdoptionStatusRequest.php)
  - Authentification: [app/Http/Requests/LoginRequest.php](app/Http/Requests/LoginRequest.php), [app/Http/Requests/RegisterRequest.php](app/Http/Requests/RegisterRequest.php)
- [x] Messages d'erreur personnalisés en francais definis dans chaque Form Request (`messages()`) et affiches globalement via [resources/views/partials/alerts.blade.php](resources/views/partials/alerts.blade.php).
- [x] Protection **CSRF** active sur tous les formulaires `POST/PUT/PATCH/DELETE` avec `@csrf`.
  - Les formulaires en `GET` (recherche/filtre) n'utilisent pas de token CSRF, conforme au fonctionnement Laravel.

### État d'implémentation — Point 7 (Authentification multi-rôles)

- [x] Trois rôles distincts implémentés et utilisés dans l'application: `admin`, `manager`, `client`.
  - Comptes de test créés par seeder: [database/seeders/DatabaseSeeder.php](database/seeders/DatabaseSeeder.php)
- [x] Système de rôles actif sur le modèle utilisateur (`users.role`) et contrôlé par middleware personnalisé.
  - Middleware de contrôle des rôles: [app/Http/Middleware/CheckRole.php](app/Http/Middleware/CheckRole.php)
  - Alias middleware: [bootstrap/app.php](bootstrap/app.php)
- [x] Redirection automatique selon le rôle après connexion.
  - Logique de redirection: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php)
  - Destination:
    - `admin` vers `admin.dashboard`
    - `manager` vers `manager.dashboard`
    - `client` vers `dashboard`
- [x] Protection des routes par rôle effective.
  - `admin.dashboard` protégé par `role:admin`
  - `manager.dashboard`, gestion des demandes et actions d'écriture protégées par `role:manager,admin`
  - Espace client (`/dashboard`) protégé par `role:client`
  - Définition des groupes de routes: [routes/web.php](routes/web.php)

### État d'implémentation — Point 8 (Middleware personnalisés)

- [x] Trois middlewares personnalisés créés manuellement:
  - [app/Http/Middleware/CheckRole.php](app/Http/Middleware/CheckRole.php)
  - [app/Http/Middleware/CheckAccountActive.php](app/Http/Middleware/CheckAccountActive.php)
  - [app/Http/Middleware/RateLimited.php](app/Http/Middleware/RateLimited.php)
- [x] Middlewares déclarés et aliasés dans [bootstrap/app.php](bootstrap/app.php):
  - `role` => controle d'acces par role
  - `active` => verification du statut actif du compte
  - `rate` => limitation du nombre de requetes par IP et par route sensible
- [x] Middlewares appliqués sur les routes concernées:
  - Groupes authentifiés: `auth` + `active`
  - Zones protégées par rôle: `role:client`, `role:manager,admin`, `role:admin`
  - Routes sensibles limitées: `login.attempt`, `register.store`, `adoptions.store`, `adoptions.status` avec `rate`
  - Référence: [routes/web.php](routes/web.php)

Rôle fonctionnel de chaque middleware:

- `CheckRole`: empêche l'accès aux utilisateurs dont le rôle n'est pas autorisé sur la route.
- `CheckAccountActive`: bloque les comptes désactivés même s'ils sont authentifiés.
- `RateLimited`: limite les abus (tentatives répétées ou spams) sur les actions critiques en imposant un quota temporel.

### État d'implémentation — Point 9 (Dashboard Administrateur)

- [x] Tableau de bord dédié administrateur disponible sur `admin.dashboard` et protégé par `role:admin`.
- [x] Statistiques globales affichées:
  - total utilisateurs
  - utilisateurs actifs/inactifs
  - total animaux
  - total demandes d'adoption
  - demandes en attente
- [x] Graphiques intégrés avec Chart.js:
  - répartition des rôles utilisateurs
  - répartition des demandes par statut
- [x] Activité récente et alertes:
  - flux des actions récentes via `journal_activites`
  - alertes des demandes en attente
- [x] Gestion complète des utilisateurs:
  - liste paginée des utilisateurs
  - activation/désactivation de compte
  - suppression (avec garde-fous: pas d'auto-suppression, pas de suppression du dernier admin)
- [x] Gestion des contenus principaux:
  - accès au catalogue animaux
  - ajout/modification/consultation d'animaux
  - accès direct au suivi des demandes d'adoption

Fichiers clés:

- Vue dashboard admin: [resources/views/dashboard/admin.blade.php](resources/views/dashboard/admin.blade.php)
- Logique métier dashboard: [app/Http/Controllers/DashboardController.php](app/Http/Controllers/DashboardController.php)
- Routes admin dashboard/utilisateurs: [routes/web.php](routes/web.php)

### État d'implémentation — Point 10 (Mailing)

- [x] Configuration email prévue pour dev et prod:
  - Dev (Mailtrap) documenté dans [.env.example](.env.example)
  - Prod (SMTP) documenté dans [.env.example](.env.example)
- [x] Au moins 4 types d'emails envoyés automatiquement:
  - Email de bienvenue à l'inscription (`EmailBienvenue`)
  - Email de confirmation d'adresse après création de compte (`EmailConfirmationAdresse`)
  - Email de confirmation d'action importante (demande d'adoption soumise) (`ConfirmationActionImportante`)
  - Email de notification de changement de statut de demande (`NotificationStatutDemande`)
  - Bonus: alerte interne nouvelle demande pour admin/manager (`AlerteNouvelleDemande`)
- [x] Utilisation des Mailables + templates Blade:
  - Mailables: [app/Mail/EmailBienvenue.php](app/Mail/EmailBienvenue.php), [app/Mail/EmailConfirmationAdresse.php](app/Mail/EmailConfirmationAdresse.php), [app/Mail/ConfirmationActionImportante.php](app/Mail/ConfirmationActionImportante.php), [app/Mail/NotificationStatutDemande.php](app/Mail/NotificationStatutDemande.php), [app/Mail/AlerteNouvelleDemande.php](app/Mail/AlerteNouvelleDemande.php)
  - Templates: [resources/views/emails/bienvenue.blade.php](resources/views/emails/bienvenue.blade.php), [resources/views/emails/confirmation-adresse.blade.php](resources/views/emails/confirmation-adresse.blade.php), [resources/views/emails/confirmation-action-importante.blade.php](resources/views/emails/confirmation-action-importante.blade.php), [resources/views/emails/notification-statut-demande.blade.php](resources/views/emails/notification-statut-demande.blade.php), [resources/views/emails/alerte-nouvelle-demande.blade.php](resources/views/emails/alerte-nouvelle-demande.blade.php)
- [x] Envoi asynchrone en file d'attente (bonus):
  - Les Mailables implémentent `ShouldQueue`
  - Les envois utilisent `Mail::queue(...)`
  - Déclencheurs automatiques dans [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php) et [app/Http/Controllers/AdoptionRequestController.php](app/Http/Controllers/AdoptionRequestController.php)
  - Exécution worker: `php artisan queue:work`

### État d'implémentation — Point 11 (Double Authentification 2FA)

- [x] OTP par email envoyé à la connexion (si 2FA activé):
  - Après validation email/mot de passe, un code OTP 6 chiffres est envoyé par email.
  - Mailable OTP: [app/Mail/CodeOtpConnexion.php](app/Mail/CodeOtpConnexion.php)
  - Template OTP: [resources/views/emails/code-otp-connexion.blade.php](resources/views/emails/code-otp-connexion.blade.php)
- [x] Saisie et validation du code OTP:
  - Formulaire de vérification: [resources/views/auth/two-factor-verify.blade.php](resources/views/auth/two-factor-verify.blade.php)
  - Routes: `two-factor.verify.form`, `two-factor.verify`, `two-factor.resend`
  - Logique: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php)
- [x] Expiration OTP:
  - Code stocké en base (`code_verifications`) avec expiration à 10 minutes.
  - Les codes expirés/invalides/utilisés sont refusés lors de la vérification.
- [x] Option activation/désactivation 2FA depuis le profil utilisateur:
  - Champ utilisateur `two_factor_enabled`.
  - Vue profil: [resources/views/profile/index.blade.php](resources/views/profile/index.blade.php)
  - Routes: `profile.show`, `profile.2fa.update`

Fichiers clés 2FA:

- Migration: [database/migrations/2026_07_04_000006_add_two_factor_enabled_to_users_table.php](database/migrations/2026_07_04_000006_add_two_factor_enabled_to_users_table.php)
- Modèle: [app/Models/User.php](app/Models/User.php)
- Contrôleur: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php)
- Routes: [routes/web.php](routes/web.php)

### État d'implémentation — Point 12 (API REST)

- [x] Endpoints RESTful documentés et fonctionnels (routes API séparées dans [routes/api.php](routes/api.php)).
- [x] Authentification API via Laravel Sanctum (tokens personnels).
  - Package installé: `laravel/sanctum`
  - Modèle utilisateur avec trait token: [app/Models/User.php](app/Models/User.php)
  - Contrôleur d'auth API: [app/Http/Controllers/Api/AuthApiController.php](app/Http/Controllers/Api/AuthApiController.php)
- [x] Réponses JSON standardisées sur l'API au format:
  - `code` (HTTP), `message`, `data`
  - Trait partagé: [app/Http/Controllers/Api/Concerns/ApiResponse.php](app/Http/Controllers/Api/Concerns/ApiResponse.php)
- [x] Au moins 5 endpoints CRUD couverts pour l'entité `animaux`.

Endpoints principaux:

- `POST /api/auth/login` (public): crée un token Sanctum.
- `GET /api/auth/me` (Bearer token): retourne l'utilisateur authentifié.
- `POST /api/auth/logout` (Bearer token): révoque le token courant.
- `GET /api/animaux` (Bearer token): liste paginée.
- `POST /api/animaux` (Bearer token): création.
- `GET /api/animaux/{animal}` (Bearer token): détail.
- `PUT/PATCH /api/animaux/{animal}` (Bearer token): mise à jour.
- `DELETE /api/animaux/{animal}` (Bearer token): suppression.

Exemple de réponse JSON standardisée:

```json
{
  "code": 200,
  "message": "Liste des animaux récupérée.",
  "data": {
    "current_page": 1,
    "data": []
  }
}
```

Exemple d'authentification:

```bash
# Login API (récupération du token)
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@exemple.com","mot_de_passe":"password","token_name":"admin-cli"}'

# Appel protégé avec Bearer token
curl http://127.0.0.1:8000/api/animaux \
  -H "Accept: application/json" \
  -H "Authorization: Bearer VOTRE_TOKEN"
```

### État d'implémentation — Point 13 (Upload & Gestion de fichiers)

- [x] Upload sécurisé des fichiers images et PDF sur l'entité `Animal`.
  - Formulaires web en `multipart/form-data`: [resources/views/animals/create.blade.php](resources/views/animals/create.blade.php), [resources/views/animals/edit.blade.php](resources/views/animals/edit.blade.php)
- [x] Validation stricte du type et de la taille des fichiers.
  - Image: `jpg,jpeg,png,webp`, max 4 Mo
  - Document: `pdf`, max 5 Mo
  - Règles dans: [app/Http/Requests/StoreAnimalRequest.php](app/Http/Requests/StoreAnimalRequest.php), [app/Http/Requests/UpdateAnimalRequest.php](app/Http/Requests/UpdateAnimalRequest.php)
- [x] Stockage organisé dans `storage/app/public`.
  - Images: `animals/images`
  - Miniatures: `animals/thumbnails`
  - Documents: `animals/documents`
  - Logique d'upload: [app/Http/Controllers/AnimalController.php](app/Http/Controllers/AnimalController.php), [app/Http/Controllers/Api/AnimalApiController.php](app/Http/Controllers/Api/AnimalApiController.php)
  - Lien public: `php artisan storage:link`
- [x] Bonus miniatures images implémenté.
  - Génération automatique de miniature lors de l'upload image via [app/Support/ImageThumbnail.php](app/Support/ImageThumbnail.php)
  - Chemins persistés en base: [database/migrations/2026_07_03_231910_add_media_columns_to_animaux_table.php](database/migrations/2026_07_03_231910_add_media_columns_to_animaux_table.php)

### État d'implémentation — Point 14 (Notifications)

- [x] Utilisation du système Notifications Laravel (`app/Notifications`).
  - [app/Notifications/NouvelleDemandeAdoptionNotification.php](app/Notifications/NouvelleDemandeAdoptionNotification.php)
  - [app/Notifications/StatutDemandeAdoptionNotification.php](app/Notifications/StatutDemandeAdoptionNotification.php)
  - [app/Notifications/StatutCompteUtilisateurNotification.php](app/Notifications/StatutCompteUtilisateurNotification.php)
- [x] Notifications en base de données avec interface "cloche".
  - Migration table `notifications`: [database/migrations/2026_07_03_231911_create_notifications_table.php](database/migrations/2026_07_03_231911_create_notifications_table.php)
  - Cloche et aperçu dans navbar: [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)
  - Page de consultation + marquage lu: [resources/views/notifications/index.blade.php](resources/views/notifications/index.blade.php), [app/Http/Controllers/NotificationController.php](app/Http/Controllers/NotificationController.php), [routes/web.php](routes/web.php)
- [x] Notifications email déclenchées par événements métier.
  - Nouvelle demande d'adoption vers admin/manager (`database` + `mail`)
  - Changement de statut du compte utilisateur (`database` + `mail`)
  - Déclencheurs: [app/Http/Controllers/AdoptionRequestController.php](app/Http/Controllers/AdoptionRequestController.php), [app/Http/Controllers/DashboardController.php](app/Http/Controllers/DashboardController.php)

### État d'implémentation — Point 15 (Événements & Listeners)

- [x] Event/Listener métier implémenté:
  - Event: [app/Events/MobilePaymentStatusUpdated.php](app/Events/MobilePaymentStatusUpdated.php)
  - Listener: [app/Listeners/SendMobilePaymentReceipt.php](app/Listeners/SendMobilePaymentReceipt.php)
  - Enregistrement: [app/Providers/EventServiceProvider.php](app/Providers/EventServiceProvider.php), [bootstrap/providers.php](bootstrap/providers.php)
- [x] Découplage effectif:
  - Le contrôleur de paiement met uniquement à jour le statut et déclenche l'event.
  - L'envoi du reçu email est exécuté dans le listener, séparé de la logique de transaction.

### État d'implémentation — Point 16 (Paiement mobile intégré)

- [x] Intégration API mobile payment via service dédié LabPay:
  - Service: [app/Services/LabPayService.php](app/Services/LabPayService.php)
  - Configuration: [config/services.php](config/services.php), [.env.example](.env.example)
  - Documentation de référence: [https://doc.api.labyrinthe-rdc.com/](https://doc.api.labyrinthe-rdc.com/)
- [x] Workflow complet implémenté:
  - Initiation: formulaire client + création transaction `en_attente`
  - Confirmation: endpoint de confirmation manuelle et endpoint callback fournisseur
  - Mise à jour du statut: `en_attente`, `reussi`, `echoue`
  - Contrôleur workflow: [app/Http/Controllers/MobilePaymentController.php](app/Http/Controllers/MobilePaymentController.php)
- [x] Historique des transactions:
  - Table dédiée: [database/migrations/2026_07_03_232409_create_mobile_payments_table.php](database/migrations/2026_07_03_232409_create_mobile_payments_table.php)
  - Modèle: [app/Models/MobilePayment.php](app/Models/MobilePayment.php)
  - Interface historique: [resources/views/payments/index.blade.php](resources/views/payments/index.blade.php)
- [x] Reçu généré automatiquement par email après paiement réussi:
  - Mailable: [app/Mail/RecuPaiementMobile.php](app/Mail/RecuPaiementMobile.php)
  - Template: [resources/views/emails/recu-paiement-mobile.blade.php](resources/views/emails/recu-paiement-mobile.blade.php)
  - Déclenché par Listener `SendMobilePaymentReceipt`.

### État d'implémentation — Point 17 (Génération de PDF)

- [x] Génération dynamique de PDF pour les reçus de paiements mobiles.
  - Contrôleur: [app/Http/Controllers/MobilePaymentController.php](app/Http/Controllers/MobilePaymentController.php)
  - Vue PDF: [resources/views/pdf/receipt-mobile-payment.blade.php](resources/views/pdf/receipt-mobile-payment.blade.php)
- [x] Utilisation d'un package dédié.
  - Package installé: `barryvdh/laravel-dompdf`
  - Mailable avec pièce jointe PDF: [app/Mail/RecuPaiementMobile.php](app/Mail/RecuPaiementMobile.php)
- [x] Téléchargement et envoi email du PDF.
  - Téléchargement: route `payments.pdf` (client)
  - Envoi email: reçu de paiement avec PDF attaché après succès transaction.

### État d'implémentation — Point 18 (Recherche avancée & Filtres)

- [x] Filtres combinés implémentés sur les écrans clés.
  - Animaux: filtre par statut, espèce, genre, tranche d'âge, recherche texte.
    - Contrôleur: [app/Http/Controllers/AnimalController.php](app/Http/Controllers/AnimalController.php)
    - Vue: [resources/views/animals/index.blade.php](resources/views/animals/index.blade.php)
  - Paiements: filtre par statut, fournisseur, date début/fin, référence/téléphone.
    - Contrôleur: [app/Http/Controllers/MobilePaymentController.php](app/Http/Controllers/MobilePaymentController.php)
    - Vue: [resources/views/payments/index.blade.php](resources/views/payments/index.blade.php)
  - Logs admin: filtre par action, entité, niveau, période, texte libre.
    - Contrôleur: [app/Http/Controllers/DashboardController.php](app/Http/Controllers/DashboardController.php)
    - Vue: [resources/views/admin/logs.blade.php](resources/views/admin/logs.blade.php)
- [x] Recherche en temps réel (AJAX) implémentée.
  - Animaux (live search): route `animals.live-search`, réponse JSON.
  - Logs admin (live search): route `admin.logs.search`, réponse JSON.

### État d'implémentation — Point 19 (Logs & Traçabilité)

- [x] Journalisation des actions sensibles.
  - Connexions réussies/échouées, OTP, déconnexions.
    - [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php)
  - Modifications/suppressions utilisateurs.
    - [app/Http/Controllers/DashboardController.php](app/Http/Controllers/DashboardController.php)
  - Création/modification/suppression animaux.
    - [app/Http/Controllers/AnimalController.php](app/Http/Controllers/AnimalController.php)
  - Paiements (initiation, confirmation, callback, téléchargement PDF).
    - [app/Http/Controllers/MobilePaymentController.php](app/Http/Controllers/MobilePaymentController.php)
- [x] Interface d'administration dédiée aux logs.
  - Vue: [resources/views/admin/logs.blade.php](resources/views/admin/logs.blade.php)
  - Routes: `admin.logs.index`, `admin.logs.search` dans [routes/web.php](routes/web.php)
- [x] Utilisation cohérente de `Log::info()` et `Log::warning()`.
  - Centralisée via helper de traçabilité: [app/Models/ActivityLog.php](app/Models/ActivityLog.php)
  - Persistance DB + écriture dans les logs applicatifs.

### État d'implémentation — Point 20 (Déploiement)

- [x] Préparation de l'application pour un déploiement en ligne.
  - Railway recommandé (simple pour Laravel + DB managée)
  - Heroku disponible comme alternative
  - Vercel analysé (moins adapté pour ce projet complet avec sessions + queue)
- [x] Fichier `.env.example` complété pour la production.
  - Variables critiques documentées: `APP_*`, `DB_*`, `SESSION_*`, `QUEUE_*`, `MAIL_*`, `LABPAY_*`
  - Exemples de valeurs production ajoutés dans [.env.example](.env.example)
- [x] Base de données de production prête à être configurée.
  - Support PostgreSQL/MySQL via `DB_CONNECTION` + `DB_URL`
  - Commandes de migration/seed documentées dans [docs/deploiement.md](docs/deploiement.md)
- [x] Fichiers de déploiement ajoutés.
  - Heroku process types: [Procfile](Procfile)
  - Railway config: [railway.json](railway.json)
  - Guide pas à pas: [docs/deploiement.md](docs/deploiement.md)

---

## Documentation (README.md et fichier pdf)

Le fichier README doit obligatoirement contenir :

- [ ] Titre et description du projet
- [ ] Nom de l'étudiant(e)
- [ ] Technologies utilisées (Laravel version, PHP version, base de données, dépendances rajoutées)
- [ ] Instructions d'installation pas à pas
- [ ] Comptes de test (email + mot de passe pour chaque rôle)
- [ ] Liste des fonctionnalités implémentées
- [ ] Schéma de la base de données (image ou lien)
- [ ] Difficultés rencontrées et solutions trouvées
- [ ] Lien vers l'application déployée *(si applicable)*

---

## Installation du projet

```bash
# 1. Cloner le dépôt
git clone https://github.com/votre-username/nom-du-projet.git
cd nom-du-projet

# 2. Installer les dépendances
composer install
npm install && npm run build

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans le fichier .env
# DB_DATABASE=nom_de_la_base
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Exécuter les migrations et les seeders
php artisan migrate --seed

# 6. Lier le stockage public
php artisan storage:link

# 7. Lancer le serveur
php artisan serve
```

---

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | <admin@exemple.com> | password |
| Gestionnaire | <gestionnaire@exemple.com> | password |
| Client | <client@exemple.com> | password |

> Ces comptes doivent être créés automatiquement par les **Seeders**.

---

## Grille d'évaluation

| Critère | Points |
|--------|--------|
| Architecture MVC & Structure du code | 10 |
| Base de données, Migrations & Relations Eloquent | 15 |
| Authentification multi-rôles & Middleware | 15 |
| Dashboard administrateur | 10 |
| CRUD complet & Validation | 10 |
| Mailing | 10 |
| Double authentification (2FA) | 10 |
| Fonctionnalités avancées (API, Paiement…) | 15 |
| Documentation & Qualité du code | 5 |
| **Total** | **100** |

---

## Règles importantes

- Le projet doit être **individuel** sauf indication contraire du professeur
- Tout plagiat ou copie de code entre étudiants entraînera la note de **0**
- Le code doit être versionné sur **GitHub** (historique de commits exigé)
- Un projet sans migrations (tables créées à la main) sera **pénalisé**
- L'application doit fonctionner sans erreur au moment de la soutenance

---

## Calendrier

| Étape | Date limite |
|-------|-------------|
| Choix du sujet validé | À définir |
| Remise du schéma de base de données | À définir |
| Remise du projet complet (GitHub) | À définir |
| Soutenance orale | À définir |

---

*Document préparé par le corps enseignant de la FASI/UPC — Cours Laravel L3 · 2025–2026*

