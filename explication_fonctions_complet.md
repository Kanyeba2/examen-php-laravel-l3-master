# Explication Fonction Par Fonction Et Bloc Par Bloc

## Objectif
- Expliquer ce que fait chaque fonction/methode detectee dans chaque fichier.
- Quand un fichier ne contient pas de fonction, expliquer les blocs de code dominants.
- Couvrir tous les fichiers applicatifs du projet (hors dependances et artefacts).

## Regles D Analyse
1. Detection automatique des fonctions PHP/JS (nom, ligne, parametres).
2. Resume du role du fichier selon son dossier (controller, model, view, etc.).
3. Resume des blocs pour les fichiers sans fonctions (Blade, routes, config, json, css, md).
4. Descriptions heuristiques basees sur les conventions Laravel et les noms de methodes.

### .editorconfig
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### .gitattributes
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### .gitignore
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### .npmrc
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### .vscode/settings.json
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier JSON declaratif (pas de fonctions). Il definit des options/outillage/dependances.

### .vscode/tasks.json
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier JSON declaratif (pas de fonctions). Il definit des options/outillage/dependances.

### app/Events/MobilePaymentStatusUpdated.php
- Role global: Declare un evenement metier declenche par une action importante.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### app/Http/Controllers/AdminManagementController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### app/Http/Controllers/AdoptionRequestController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 5
- Ligne 23: index() -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 38: create(Animal $animal) -> Affiche le formulaire de creation d une ressource.
- Ligne 50: store(StoreAdoptionRequest $request, Animal $animal) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 92: updateStatus(UpdateAdoptionStatusRequest $request, AdoptionRequest $adoptionRequest) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 114: resumeDemandePourUtilisateur(Animal $animal, int $utilisateurId) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/AnimalController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 10
- Ligne 22: index(Request $request) -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 101: toggleFavorite(Animal $animal) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 121: liveSearch(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 152: create() -> Affiche le formulaire de creation d une ressource.
- Ligne 157: store(StoreAnimalRequest $request) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 190: show(Animal $animal) -> Affiche le detail d une ressource precise.
- Ligne 202: edit(Animal $animal) -> Affiche le formulaire de modification d une ressource.
- Ligne 207: update(UpdateAnimalRequest $request, Animal $animal) -> Valide puis met a jour une ressource existante.
- Ligne 251: destroy(Animal $animal) -> Supprime une ressource et gere les effets associes.
- Ligne 282: resumeDemandePourUtilisateur(Animal $animal, int $utilisateurId) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/Api/AnimalApiController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 5
- Ligne 20: index() -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 27: store(StoreAnimalRequest $request) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 52: show(Animal $animal) -> Affiche le detail d une ressource precise.
- Ligne 57: update(UpdateAnimalRequest $request, Animal $animal) -> Valide puis met a jour une ressource existante.
- Ligne 93: destroy(Animal $animal) -> Supprime une ressource et gere les effets associes.

### app/Http/Controllers/Api/AuthApiController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 3
- Ligne 15: login(Request $request) -> Gere une etape du cycle d authentification utilisateur.
- Ligne 48: me(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 53: logout(Request $request) -> Gere une etape du cycle d authentification utilisateur.

### app/Http/Controllers/Api/Concerns/ApiResponse.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 2
- Ligne 9: success(string $message, mixed $data = null, int $status = 200) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 18: error(string $message, int $status = 400, mixed $data = null) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/Api/DemandeAdoptionApiController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 4
- Ligne 17: index() -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 24: store(StoreAdoptionRequest $request) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 38: show(AdoptionRequest $demandes_adoption) -> Affiche le detail d une ressource precise.
- Ligne 43: destroy(AdoptionRequest $demandes_adoption) -> Supprime une ressource et gere les effets associes.

### app/Http/Controllers/AuthController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 13
- Ligne 23: showLogin() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 28: login(LoginRequest $request) -> Gere une etape du cycle d authentification utilisateur.
- Ligne 96: showRegister() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 101: register(RegisterRequest $request) -> Enregistre des services/bindings dans le conteneur Laravel.
- Ligne 135: logout(Request $request) -> Gere une etape du cycle d authentification utilisateur.
- Ligne 154: showTwoFactorForm(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 163: verifyTwoFactorCode(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 223: resendTwoFactorCode(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 248: showProfile() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 255: updateProfile(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 291: updateTwoFactorSetting(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 306: createOtpCodeFor(User $user) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 324: redirectToRole(string $role) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/CmsContentController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 8
- Ligne 14: create(Request $request) -> Affiche le formulaire de creation d une ressource.
- Ligne 26: store(Request $request) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 41: edit(CmsContent $cmsContent) -> Affiche le formulaire de modification d une ressource.
- Ligne 49: update(Request $request, CmsContent $cmsContent) -> Valide puis met a jour une ressource existante.
- Ligne 65: destroy(CmsContent $cmsContent) -> Supprime une ressource et gere les effets associes.
- Ligne 75: publicIndex() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 92: validateContent(Request $request, ?CmsContent $content = null) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 118: indexRouteForType(string $type) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/ContenuCmsController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 15
- Ligne 14: creer(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 26: enregistrer(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 39: modifier(ContenuCms $contenuCms) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 47: mettreAJour(Request $request, ContenuCms $contenuCms) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 58: supprimer(ContenuCms $contenuCms) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 66: pagePublique() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 83: create(Request $request) -> Affiche le formulaire de creation d une ressource.
- Ligne 88: store(Request $request) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 93: edit(ContenuCms $contenuCms) -> Affiche le formulaire de modification d une ressource.
- Ligne 98: update(Request $request, ContenuCms $contenuCms) -> Valide puis met a jour une ressource existante.
- Ligne 103: destroy(ContenuCms $contenuCms) -> Supprime une ressource et gere les effets associes.
- Ligne 108: publicIndex() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 113: validerContenu(Request $request, ?ContenuCms $contenu = null) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 139: routeIndexSelonType(string $type) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 147: genererSlugUnique(string $base, ?int $ignoreId = null) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/Controller.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### app/Http/Controllers/DashboardController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 11
- Ligne 21: admin(\Illuminate\Http\Request $request) -> Construit les donnees du tableau de bord pour ce role utilisateur.
- Ligne 211: searchLogs(\Illuminate\Http\Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 244: toggleUserActive(User $user) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 269: destroyUser(User $user) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 295: manager() -> Construit les donnees du tableau de bord pour ce role utilisateur.
- Ligne 339: client(\Illuminate\Http\Request $request) -> Construit les donnees du tableau de bord pour ce role utilisateur.
- Ligne 386: adoptants() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 437: paiements() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 512: suiviPostAdoption() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 534: articlesConseils() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 559: pagesCms() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/GestionAdministrationController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 17
- Ligne 27: listeUtilisateurs() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 40: modifierUtilisateur(User $utilisateur) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 45: mettreAJourUtilisateur(Request $request, User $utilisateur) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 65: listeRolesPermissions() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 81: mettreAJourRolesPermissions(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 99: listeParametres() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 106: mettreAJourParametres(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 131: usersIndex() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 136: editUser(User $user) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 141: updateUser(Request $request, User $user) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 146: rolesPermissionsIndex() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 151: updateRolesPermissions(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 156: settingsIndex() -> Ajuste une valeur/etat interne avant persistence ou rendu.
- Ligne 161: settingsUpdate(Request $request) -> Ajuste une valeur/etat interne avant persistence ou rendu.
- Ligne 166: carteDesParametres() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 180: enregistrerParametre(string $cle, string $libelle, string $valeur, string $type, string $groupe) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 193: etatPermissionParDefaut(string $role, string $permission) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/MobilePaymentController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 7
- Ligne 22: index() -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 83: store(InitiateMobilePaymentRequest $request, LabPayService $labPayService) -> Valide puis enregistre une nouvelle ressource en base.
- Ligne 148: confirm(ConfirmMobilePaymentRequest $request, MobilePayment $mobilePayment, LabPayService $labPayService) -> Valide et confirme une action sensible (paiement, verification, etc.).
- Ligne 191: callback(Request $request) -> Traite un retour asynchrone provenant d un service externe.
- Ligne 235: pdf(MobilePayment $mobilePayment) -> Genere ou retourne un document PDF pour la ressource.
- Ligne 264: normalizeStatus(string $status) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 273: synchroniserStatutAnimalSiAdoptionFinalisee(MobilePayment $payment) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Controllers/NotificationController.php
- Role global: Controle les requetes HTTP, la logique metier et la reponse finale.
- Fonctions/methodes detectees: 3
- Ligne 11: index(Request $request) -> Affiche une liste de ressources avec eventuels filtres et pagination.
- Ligne 22: markAsRead(Request $request, string $notificationId) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 32: markAllAsRead(Request $request) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Http/Middleware/CheckAccountActive.php
- Role global: Filtre les requetes (acces, role, etat compte, limitations).
- Fonctions/methodes detectees: 1
- Ligne 11: handle(Request $request, Closure $next) -> Intercepte la requete et applique une regle transversale.

### app/Http/Middleware/CheckRole.php
- Role global: Filtre les requetes (acces, role, etat compte, limitations).
- Fonctions/methodes detectees: 1
- Ligne 11: handle(Request $request, Closure $next, string ...$roles) -> Intercepte la requete et applique une regle transversale.

### app/Http/Middleware/RateLimited.php
- Role global: Filtre les requetes (acces, role, etat compte, limitations).
- Fonctions/methodes detectees: 1
- Ligne 11: handle(Request $request, Closure $next) -> Intercepte la requete et applique une regle transversale.

### app/Http/Requests/ConfirmMobilePaymentRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 2
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.

### app/Http/Requests/InitiateMobilePaymentRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 25: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/LoginRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 23: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/RegisterRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 25: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/StoreAdoptionRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 21: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/StoreAnimalRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 32: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/UpdateAdoptionStatusRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 21: messages() -> Personnalise les messages d erreur de validation.

### app/Http/Requests/UpdateAnimalRequest.php
- Role global: Valide les entrees utilisateur avant traitement dans les controleurs.
- Fonctions/methodes detectees: 3
- Ligne 9: authorize() -> Autorise ou bloque la requete avant validation/traitement.
- Ligne 14: rules() -> Definit les regles de validation des champs recus.
- Ligne 32: messages() -> Personnalise les messages d erreur de validation.

### app/Listeners/SendMobilePaymentReceipt.php
- Role global: Ecoute un evenement et execute une reaction associee.
- Fonctions/methodes detectees: 1
- Ligne 12: handle(MobilePaymentStatusUpdated $event) -> Intercepte la requete et applique une regle transversale.

### app/Mail/AlerteNouvelleDemande.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 17: __construct(AdoptionRequest $demande) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 22: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/CodeOtpConnexion.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 17: __construct($utilisateur, string $code) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 23: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/ConfirmationActionImportante.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 17: __construct(AdoptionRequest $demande) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 22: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/EmailBienvenue.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 16: __construct($utilisateur) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 21: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/EmailConfirmationAdresse.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 18: __construct($utilisateur, string $code) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 24: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/NotificationStatutDemande.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 2
- Ligne 17: __construct(AdoptionRequest $demande) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 22: build() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Mail/RecuPaiementMobile.php
- Role global: Construit un email metier (sujet, vue, donnees envoyees).
- Fonctions/methodes detectees: 4
- Ligne 19: __construct(public MobilePayment $payment) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 24: envelope() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 31: content() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 38: attachments() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/ActivityLog.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 21: user() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/AdoptionRequest.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 4
- Ligne 21: utilisateur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 26: animal() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 31: suivis() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 36: paiementsMobiles() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/Animal.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 3
- Ligne 35: createur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 40: demandesAdoption() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 45: favoriParUtilisateurs() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/CmsContent.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 32: author() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/CodeVerification.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 22: utilisateur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/ContenuCms.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 32: auteur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/FollowUp.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 2
- Ligne 24: demandeAdoption() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 29: utilisateur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/MobilePayment.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 2
- Ligne 32: utilisateur() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 37: demandeAdoption() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/ParametreSysteme.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 19: obtenirValeur(string $cle, mixed $defaut = null) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### app/Models/PermissionRole.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### app/Models/RolePermission.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### app/Models/SystemSetting.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 1
- Ligne 19: getValue(string $key, mixed $default = null) -> Recupere une information ciblee a partir des donnees metier.

### app/Models/User.php
- Role global: Definit les entites metier, relations et transformations de donnees.
- Fonctions/methodes detectees: 8
- Ligne 40: getAuthPassword() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 45: animaux() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 50: demandesAdoption() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 55: suivis() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 60: journalActivites() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 65: paiementsMobiles() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 70: favorisAnimaux() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 75: hasPermission(string $permission) -> Retourne une condition booleenne liee aux droits ou etats metier.

### app/Notifications/NouvelleDemandeAdoptionNotification.php
- Role global: Construit des notifications base/mail envoyees aux utilisateurs.
- Fonctions/methodes detectees: 4
- Ligne 14: __construct(private readonly AdoptionRequest $adoptionRequest) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 18: via(object $notifiable) -> Definit les canaux de notification (database, mail, etc.).
- Ligne 23: toMail(object $notifiable) -> Construit le contenu de la notification email.
- Ligne 36: toArray(object $notifiable) -> Transforme l objet en tableau pour serialisation/transport.

### app/Notifications/StatutCompteUtilisateurNotification.php
- Role global: Construit des notifications base/mail envoyees aux utilisateurs.
- Fonctions/methodes detectees: 4
- Ligne 13: __construct(private readonly bool $actif) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 17: via(object $notifiable) -> Definit les canaux de notification (database, mail, etc.).
- Ligne 22: toMail(object $notifiable) -> Construit le contenu de la notification email.
- Ligne 32: toArray(object $notifiable) -> Transforme l objet en tableau pour serialisation/transport.

### app/Notifications/StatutDemandeAdoptionNotification.php
- Role global: Construit des notifications base/mail envoyees aux utilisateurs.
- Fonctions/methodes detectees: 3
- Ligne 13: __construct(private readonly AdoptionRequest $adoptionRequest) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 17: via(object $notifiable) -> Definit les canaux de notification (database, mail, etc.).
- Ligne 22: toArray(object $notifiable) -> Transforme l objet en tableau pour serialisation/transport.

### app/Providers/AppServiceProvider.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 2
- Ligne 16: register() -> Enregistre des services/bindings dans le conteneur Laravel.
- Ligne 24: boot() -> Configure des comportements globaux au demarrage du service provider.

### app/Providers/EventServiceProvider.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 1
- Ligne 17: boot() -> Configure des comportements globaux au demarrage du service provider.

### app/Services/LabPayService.php
- Role global: Centralise une logique metier reutilisable ou integration externe.
- Fonctions/methodes detectees: 3
- Ligne 11: initiate(MobilePayment $payment) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 60: confirm(MobilePayment $payment) -> Valide et confirme une action sensible (paiement, verification, etc.).
- Ligne 106: isEnabled() -> Retourne une condition booleenne liee aux droits ou etats metier.

### app/Support/ImageThumbnail.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 1
- Ligne 9: generate(string $sourceRelativePath, string $thumbRelativePath, int $maxWidth = 320, int $maxHeight = 320) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### artisan
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### bootstrap/app.php
- Role global: Initialise le cycle de vie de l application au demarrage.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### bootstrap/providers.php
- Role global: Initialise le cycle de vie de l application au demarrage.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### composer.json
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier JSON declaratif (pas de fonctions). Il definit des options/outillage/dependances.

### composer-setup.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 51
- Ligne 21: setupEnvironment() -> Ajuste une valeur/etat interne avant persistence ou rendu.
- Ligne 48: process($argv) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 114: displayHelp() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 145: setUseAnsi($argv) -> Ajuste une valeur/etat interne avant persistence ou rendu.
- Ligne 162: outputSupportsColor() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 202: getOptValue($opt, $argv, $default) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 229: checkParams($installDir, $version, $cafile) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 262: checkPlatform(&$warnings, $quiet, $disableTls, $install) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 295: getPlatformIssues(&$errors, &$warnings, $install) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 501: outputIssues($issues) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 514: showWarnings($warnings) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 528: showSecurityWarning($disableTls) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 539: out($text, $color = null, $newLine = true) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 565: getHomeDir() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 609: getUserDir() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 624: useXdg() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 639: validateCaFile($contents) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 659: getIniMessage() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 709: __construct($quiet, $disableTls, $caFile) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 730: run($version, $installDir, $filename, $channel) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 771: initTargets($installDir, $filename) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 791: initTls() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 820: getComposerHome() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 850: installKey($data, $path, $filename) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 880: install($version, $channel) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 935: getVersion($channel, &$version, &$url, &$error) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 964: downloadVersionData(&$data, &$error) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 990: downloadToTmp($url, &$signature, &$error) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1023: verifyAndSave($version, $signature, &$error) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1054: parseVersionData(array $data, $channel, &$version, &$url) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1084: getSignature($url, &$signature) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1108: verifySignature($version, $signature, $file) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1138: validatePhar($pharFile, &$error) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1166: getJsonError() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1180: cleanUp($result) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1203: outputErrors(array $errors) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1219: uninstall() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1234: getPKDev() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1254: getPKTags() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1286: handleError($code, $msg) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1299: start() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1313: stop() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1327: __construct($pattern) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1350: test($url) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1378: __construct($disableTls = false, $cafile = false) -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 1392: get($url) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1433: getStreamContext($url) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1444: getTlsStreamContextDefaults($cafile) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1539: getMergedStreamContext($url) -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1659: getSystemCaRootBundlePath() -> Recupere une information ciblee a partir des donnees metier.
- Ligne 1722: getPackagedCaFile() -> Recupere une information ciblee a partir des donnees metier.

### config/app.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): name, env, debug, url, timezone, locale, fallback_locale, faker_locale.

### config/auth.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): defaults, guard, passwords, guards, web, driver, provider, providers.

### config/cache.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, stores, array, driver, serialize, database, connection, table.

### config/database.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, connections, sqlite, driver, url, database, prefix, foreign_key_constraints.

### config/filesystems.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, disks, local, driver, root, serve, throw, report.

### config/logging.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, deprecations, channel, trace, channels, stack, driver, ignore_exceptions.

### config/mail.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, mailers, smtp, transport, scheme, url, host, port.

### config/queue.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): default, connections, sync, driver, database, connection, table, queue.

### config/sanctum.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): stateful, guard, expiration, token_prefix, middleware, authenticate_session, encrypt_cookies, validate_csrf_token.

### config/services.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): postmark, key, resend, ses, secret, region, slack, notifications.

### config/session.php
- Role global: Configure le comportement global de l application Laravel.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de configuration sans fonctions. Cles importantes (extrait): driver, lifetime, expire_on_close, encrypt, files, connection, table, store.

### database/.gitignore
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### database/factories/UserFactory.php
- Role global: Genere des donnees factices pour tests.
- Fonctions/methodes detectees: 2
- Ligne 25: definition() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.
- Ligne 43: unverified() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### database/migrations/0001_01_01_000000_create_users_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 12: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 47: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/0001_01_01_000001_create_cache_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 12: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 30: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/0001_01_01_000002_create_jobs_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 12: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 53: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_06_29_000001_create_animals_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 28: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_06_29_000002_create_adoption_requests_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 22: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_06_29_000003_create_follow_ups_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 22: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_06_29_000004_create_activity_logs_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 22: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_03_000005_create_code_verifications_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 21: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_03_231512_create_personal_access_tokens_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 12: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 29: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_03_231910_add_media_columns_to_animaux_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 17: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_03_231911_create_notifications_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 21: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_03_232409_create_mobile_payments_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 31: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000006_add_two_factor_enabled_to_users_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 16: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000007_create_animal_favorites_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 21: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000008_add_profile_photo_path_to_users_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 16: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000010_create_cms_contents_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 31: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000011_create_system_settings_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 22: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000012_create_role_permissions_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 23: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000013_renommer_tables_metier_en_francais.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 8: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 23: down() -> Annule la migration: retire les structures ajoutees par up().

### database/migrations/2026_07_04_000014_add_prix_adoption_to_animaux_table.php
- Role global: Definit l evolution du schema SQL versionnee dans le temps.
- Fonctions/methodes detectees: 2
- Ligne 9: up() -> Applique la migration: cree/modifie les tables, colonnes, contraintes et indexes.
- Ligne 16: down() -> Annule la migration: retire les structures ajoutees par up().

### database/seeders/DatabaseSeeder.php
- Role global: Prepare des donnees de demo/test rejouables.
- Fonctions/methodes detectees: 1
- Ligne 18: run() -> Insere les donnees de depart (roles, users, animaux, demandes, etc.).

### docs/schema-base-de-donnees.md
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de documentation (pas de fonctions executables).

### explanation_complet.md
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de documentation (pas de fonctions executables).

### package.json
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier JSON declaratif (pas de fonctions). Il definit des options/outillage/dependances.

### phpunit.xml
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### public/.htaccess
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### public/index.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### public/robots.txt
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### README.md
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de documentation (pas de fonctions executables).

### resources/css/app.css
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Feuille de style (pas de fonctions). Blocs CSS detectes approximativement: 3.

### resources/js/app.js
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### resources/lang/en/messages.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### resources/lang/fr/messages.php
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### resources/views/admin/adoptants.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=6, boucles=2, composition=2, formulaires=0.

### resources/views/admin/articles-conseils.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=2, composition=2, formulaires=3.

### resources/views/admin/cms/form.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=2, composition=2, formulaires=12.

### resources/views/admin/logs.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 1
- Ligne 387: masquerResultatsLogs() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### resources/views/admin/pages.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=2, composition=2, formulaires=3.

### resources/views/admin/paiements.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=8, boucles=2, composition=2, formulaires=8.

### resources/views/admin/roles-permissions.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=2, composition=2, formulaires=3.

### resources/views/admin/settings.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=2, formulaires=10.

### resources/views/admin/suivi-post-adoption.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=2, boucles=1, composition=2, formulaires=0.

### resources/views/admin/users/edit.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=0, composition=2, formulaires=10.

### resources/views/admin/users/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=2, composition=2, formulaires=6.

### resources/views/adoptions/create.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=5, boucles=1, composition=2, formulaires=3.

### resources/views/adoptions/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=5, boucles=1, composition=2, formulaires=3.

### resources/views/animals/create.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=2, formulaires=14.

### resources/views/animals/edit.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=3, boucles=0, composition=2, formulaires=15.

### resources/views/animals/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 1
- Ligne 520: masquerResultatsLive() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### resources/views/animals/show.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=4, boucles=0, composition=2, formulaires=0.

### resources/views/auth/login.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=1, composition=2, formulaires=5.

### resources/views/auth/register.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=1, composition=2, formulaires=8.

### resources/views/auth/two-factor-verify.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=1, composition=2, formulaires=5.

### resources/views/cms/conseils.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=2, composition=2, formulaires=0.

### resources/views/dashboard/admin.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 1
- Ligne 1068: initialiserGraphiquesAdmin() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### resources/views/dashboard/client.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=5, boucles=2, composition=2, formulaires=4.

### resources/views/dashboard/manager.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=3, composition=2, formulaires=0.

### resources/views/emails/alerte-nouvelle-demande.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/bienvenue.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/code-otp-connexion.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/confirmation-action-importante.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/confirmation-adresse.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/notification-statut-demande.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=0, boucles=0, composition=0, formulaires=0.

### resources/views/emails/recu-paiement-mobile.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=2, boucles=0, composition=0, formulaires=0.

### resources/views/layouts/app.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=3, boucles=1, composition=3, formulaires=5.

### resources/views/notifications/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=3, boucles=1, composition=2, formulaires=4.

### resources/views/partials/alerts.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=2, boucles=1, composition=0, formulaires=0.

### resources/views/partials/user-identity.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=1, boucles=0, composition=0, formulaires=0.

### resources/views/payments/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=13, boucles=3, composition=2, formulaires=15.

### resources/views/pdf/receipt-mobile-payment.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=5, boucles=0, composition=0, formulaires=0.

### resources/views/profile/index.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=2, boucles=0, composition=2, formulaires=12.

### resources/views/welcome.blade.php
- Role global: Construit l interface utilisateur Blade (HTML + directives serveur).
- Fonctions/methodes detectees: 0
- Blocs dominants: Template Blade sans declaration de fonctions. Blocs dominants: conditions=4, boucles=0, composition=0, formulaires=1.

### routes/api.php
- Role global: Definit les routes, middleware et points d entree web/api/console.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de routes sans fonctions metier principales. Nombre de declarations Route::* detectees: 5.

### routes/console.php
- Role global: Definit les routes, middleware et points d entree web/api/console.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de routes sans fonctions metier principales. Nombre de declarations Route::* detectees: 0.

### routes/web.php
- Role global: Definit les routes, middleware et points d entree web/api/console.
- Fonctions/methodes detectees: 0
- Blocs dominants: Fichier de routes sans fonctions metier principales. Nombre de declarations Route::* detectees: 60.

### tests/Feature/AuthTest.php
- Role global: Verifie automatiquement le comportement attendu du projet.
- Fonctions/methodes detectees: 1
- Ligne 12: test_user_can_register_and_be_redirected_to_dashboard() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### tests/Feature/ExampleTest.php
- Role global: Verifie automatiquement le comportement attendu du projet.
- Fonctions/methodes detectees: 1
- Ligne 13: test_the_application_returns_a_successful_response() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### tests/TestCase.php
- Role global: Verifie automatiquement le comportement attendu du projet.
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

### tests/Unit/ExampleTest.php
- Role global: Verifie automatiquement le comportement attendu du projet.
- Fonctions/methodes detectees: 1
- Ligne 12: test_that_true_is_true() -> Execute une logique metier specifique a ce fichier. Lire le corps de la fonction pour les details exacts.

### vite.config.js
- Role global: Fichier de support (documentation, outillage, build, qualite, assets).
- Fonctions/methodes detectees: 0
- Blocs dominants: Pas de fonction detectee automatiquement. Lire les blocs conditionnels, declarations et structures de ce fichier.

## Limites De Cette Version
- Cette version est automatique: elle couvre tout le projet vite, mais reste heuristique.
- Pour les fichiers critiques, une analyse manuelle methode par methode peut encore enrichir les details.
