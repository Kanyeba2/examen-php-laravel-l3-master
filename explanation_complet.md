# Explication Complete Du Projet

## Portee
- Ce document couvre les fichiers applicatifs de la base Laravel.
- Les dossiers tiers/generes (vendor, node_modules, caches, public/storage) sont exclus.

## MVC Dans Ce Projet
- M (Modele): app/Models
- V (Vue): resources/views
- C (Controleur): app/Http/Controllers
- Support: routes, middleware, requests, services, events/listeners, config, migrations, seeders, tests.

## Methode De Lecture D un Fichier
1. Lire les imports et dependances.
2. Lire les methodes publiques (flux principal).
3. Lire les validations, conditions et retours.
4. Suivre les variables entree -> traitement -> sortie.
5. Verifier les interactions entre couches MVC.

## Fiches Par Fichier

### .editorconfig
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .env.example
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .gitattributes
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .gitignore
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .npmrc
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .vscode/settings.json
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### .vscode/tasks.json
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Events/MobilePaymentStatusUpdated.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Architecture evenementielle et actions decouplees.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Http/Controllers/AdminManagementController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/AdoptionRequestController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Creation des demandes; transitions de statut; notifications et journalisation.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/AnimalController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: CRUD animaux; media; filtres/tri; gestion favoris.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/Api/AnimalApiController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/Api/AuthApiController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/Api/Concerns/ApiResponse.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/Api/DemandeAdoptionApiController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/AuthController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Inscription/connexion; OTP/2FA; verification compte; redirection selon role.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/CmsContentController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/ContenuCmsController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/Controller.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/DashboardController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Methodes dashboard par role; calcul KPI; listes prioritaires et indicateurs de pilotage.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/GestionAdministrationController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/MobilePaymentController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Flux paiement: index/store/confirm/callback/pdf; montant force cote serveur; rattachement a la demande adoption.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Controllers/NotificationController.php
- Couche MVC: C
- Pourquoi ce fichier existe: Orchestration HTTP: requete -> validation -> modele -> reponse.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $request, $validated, $query/$filters, $model/$record, $stats, donnees envoyees a la vue.

### app/Http/Middleware/CheckAccountActive.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Filtrage de requete: acces, securite, etat compte, limitation.
- Blocs de code a comprendre: handle(): controle prealable avant execution du controleur.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Http/Middleware/CheckRole.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Filtrage de requete: acces, securite, etat compte, limitation.
- Blocs de code a comprendre: handle(): controle prealable avant execution du controleur.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Http/Middleware/RateLimited.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Filtrage de requete: acces, securite, etat compte, limitation.
- Blocs de code a comprendre: handle(): controle prealable avant execution du controleur.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Http/Requests/ConfirmMobilePaymentRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/InitiateMobilePaymentRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/LoginRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/RegisterRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/StoreAdoptionRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/StoreAnimalRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/UpdateAdoptionStatusRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Http/Requests/UpdateAnimalRequest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Validation centralisee des donnees entrantes (FormRequest).
- Blocs de code a comprendre: rules(), messages(), authorize(): coeur des validations formulaire.
- Variables importantes: Variables clefs: tableaux rules/messages/authorize qui encadrent les inputs.

### app/Listeners/SendMobilePaymentReceipt.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Architecture evenementielle et actions decouplees.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/AlerteNouvelleDemande.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/CodeOtpConnexion.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/ConfirmationActionImportante.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/EmailBienvenue.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/EmailConfirmationAdresse.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/NotificationStatutDemande.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Mail/RecuPaiementMobile.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Construction des emails metier.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Models/ActivityLog.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/AdoptionRequest.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/Animal.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/CmsContent.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/CodeVerification.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/ContenuCms.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/FollowUp.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/MobilePayment.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/ParametreSysteme.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/PermissionRole.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/RolePermission.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/SystemSetting.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Models/User.php
- Couche MVC: M
- Pourquoi ce fichier existe: Entite metier: structure des donnees, relations, casts, scopes.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: $fillable, $casts, relations Eloquent, scopes et constantes de statut.

### app/Notifications/NouvelleDemandeAdoptionNotification.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Notifications base/mail pour les utilisateurs.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Notifications/StatutCompteUtilisateurNotification.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Notifications base/mail pour les utilisateurs.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Notifications/StatutDemandeAdoptionNotification.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Notifications base/mail pour les utilisateurs.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Providers/AppServiceProvider.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Providers/EventServiceProvider.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Services/LabPayService.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Service metier/integration externe.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### app/Support/ImageThumbnail.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### artisan
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### bootstrap/app.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### bootstrap/providers.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### cacert.pem
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer.json
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer.lock
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer.phar
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer-install-nodev-verbose.log
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer-install-source.log
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer-install-verbose.log
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### composer-setup.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/app.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/auth.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/cache.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/database.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/filesystems.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/logging.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/mail.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/queue.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/sanctum.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/services.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### config/session.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### database/.gitignore
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### database/database.sqlite
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### database/factories/UserFactory.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### database/migrations/0001_01_01_000000_create_users_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/0001_01_01_000001_create_cache_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/0001_01_01_000002_create_jobs_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_06_29_000001_create_animals_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_06_29_000002_create_adoption_requests_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_06_29_000003_create_follow_ups_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_06_29_000004_create_activity_logs_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_03_000005_create_code_verifications_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_03_231512_create_personal_access_tokens_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_03_231910_add_media_columns_to_animaux_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_03_231911_create_notifications_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_03_232409_create_mobile_payments_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000006_add_two_factor_enabled_to_users_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000007_create_animal_favorites_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000008_add_profile_photo_path_to_users_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000010_create_cms_contents_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000011_create_system_settings_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000012_create_role_permissions_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000013_renommer_tables_metier_en_francais.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/migrations/2026_07_04_000014_add_prix_adoption_to_animaux_table.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Evolution versionnee du schema SQL.
- Blocs de code a comprendre: up(): creation/modification tables/contraintes/index; down(): rollback propre.
- Variables importantes: Variables clefs: nom table, colonnes, types, clefs etrangeres, indexes, default.

### database/seeders/DatabaseSeeder.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Initialisation des donnees de test/demo de maniere rejouable.
- Blocs de code a comprendre: Creation de comptes, animaux, demandes, paiements, parametres; usage updateOrCreate pour rejouer sans erreurs.
- Variables importantes: Variables clefs: jeux de donnees source, roles, statuts, montants, dates, references relationnelles.

### docs/schema-base-de-donnees.md
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### explanation_complet.md
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### package.json
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### phpunit.xml
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### public/.htaccess
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### public/favicon.ico
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### public/index.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### public/robots.txt
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### README.md
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### resources/css/app.css
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### resources/js/app.js
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### resources/lang/en/messages.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### resources/lang/fr/messages.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### resources/views/admin/adoptants.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/articles-conseils.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/cms/form.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/logs.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/pages.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/paiements.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Vue globale paiements admin: filtres, table compacte, badges statut, acces facture PDF.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/roles-permissions.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/settings.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/suivi-post-adoption.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/users/edit.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/admin/users/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/adoptions/create.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/adoptions/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/animals/create.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/animals/edit.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/animals/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/animals/show.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/auth/login.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/auth/register.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/auth/two-factor-verify.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/cms/conseils.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/dashboard/admin.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/dashboard/client.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/dashboard/manager.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Dashboard gestionnaire oriente taches: demandes, suivis, priorites, actions rapides.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/alerte-nouvelle-demande.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/bienvenue.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/code-otp-connexion.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/confirmation-action-importante.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/confirmation-adresse.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/notification-statut-demande.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/emails/recu-paiement-mobile.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/layouts/app.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/notifications/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/partials/alerts.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/partials/user-identity.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/payments/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/pdf/receipt-mobile-payment.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/profile/index.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### resources/views/welcome.blade.php
- Couche MVC: V
- Pourquoi ce fichier existe: Presentation Blade: rendu HTML, sections, conditions et boucles d affichage.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs Blade: collections et compteurs provenant du controleur (ex: $animals, $requests, $payments, $stats).

### routes/api.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Routage URL/API, nommage des routes et middleware.
- Blocs de code a comprendre: Endpoints API, authentification token, normalisation des reponses.
- Variables importantes: Variables clefs: URI, nom de route, middleware, action controleur, prefixe.

### routes/console.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Routage URL/API, nommage des routes et middleware.
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables clefs: URI, nom de route, middleware, action controleur, prefixe.

### routes/web.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Routage URL/API, nommage des routes et middleware.
- Blocs de code a comprendre: Groupes middleware, routes nommees, separation admin/manager/client et pages metier.
- Variables importantes: Variables clefs: URI, nom de route, middleware, action controleur, prefixe.

### tests/Feature/AuthTest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### tests/Feature/ExampleTest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### tests/TestCase.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### tests/Unit/ExampleTest.php
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### tools/generate_explanation.ps1
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

### vite.config.js
- Couche MVC: Support
- Pourquoi ce fichier existe: Fichier de support projet (config, outillage, documentation ou tests).
- Blocs de code a comprendre: Identifier les methodes/fonctions principales puis les blocs conditionnels qui portent la regle metier.
- Variables importantes: Variables a suivre: entree utilisateur, donnees validees, donnees transformees, et sortie finale.

## Cartographie Rapide
- app/Http/Controllers: aggregation et orchestration des flux HTTP.
- app/Models: coeur de donnees et relations SQL.
- resources/views: ecrans Blade par role (admin, manager, client).
- database/migrations + seeders: schema et donnees initiales.
- routes: navigation web/API et securisation middleware.

## Suite Possible
- Une v2 encore plus detaillee peut etre produite methode par methode sur les fichiers critiques.
