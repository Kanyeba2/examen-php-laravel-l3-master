<?php

use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\GestionAdministrationController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContenuCmsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MobilePaymentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// je donne la route pour la page d'accueil et redirige les utilisateurs vers le tableau de bord approprié en fonction de leur rôle (admin, manager, client)
Route::get('/', function () {
    // Central entrypoint: route users to the right dashboard based on role.
    if (!Auth::check()) {
        return redirect()->route('login');
    }
// je donne la route pour la page d'accueil et redirige les utilisateurs vers le tableau de bord approprié en fonction de leur rôle (admin, manager, client)
    $user = Auth::user();

    return match ($user?->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'manager' => redirect()->route('manager.dashboard'),
        default => redirect()->route('dashboard'),
    };
})->name('home');
// je donne la route pour la page de test de l'API
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('rate');
    Route::get('/2fa/verifier', [AuthController::class, 'showTwoFactorForm'])->name('two-factor.verify.form');
    Route::post('/2fa/verifier', [AuthController::class, 'verifyTwoFactorCode'])->name('two-factor.verify')->middleware('rate');
    Route::post('/2fa/renvoyer', [AuthController::class, 'resendTwoFactorCode'])->name('two-factor.resend')->middleware('rate');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store')->middleware('rate');
});
// je donne la route pour la page de deconnexion de l'utilisateur
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
//c'est quoi middleware 'auth' et 'active' ?
// 'auth' middleware assure que l'utilisateur est authentifie et 'active' middleware verifie si le compte d'utilisateur est actif. si l'une des conditions échoue, l'utilisateur sera redirigé vers la page de connexion ou une page d'erreur appropriée.
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'client'])->name('dashboard')->middleware('role:client');
    Route::get('/profil', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::patch('/profil', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('rate');
    Route::patch('/profil/2fa', [AuthController::class, 'updateTwoFactorSetting'])->name('profile.2fa.update')->middleware('rate');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/paiements', [MobilePaymentController::class, 'index'])->name('payments.index')->middleware('role:client');
    Route::post('/paiements', [MobilePaymentController::class, 'store'])->name('payments.store')->middleware('role:client');
    Route::post('/paiements/{mobilePayment}/confirmer', [MobilePaymentController::class, 'confirm'])->name('payments.confirm')->middleware('role:client');
    Route::get('/paiements/{mobilePayment}/pdf', [MobilePaymentController::class, 'pdf'])->name('payments.pdf')->middleware('role:client');

    Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
    Route::get('/animals/{animal}', [AnimalController::class, 'show'])->whereNumber('animal')->name('animals.show');
    Route::get('/animaux/recherche/live', [AnimalController::class, 'liveSearch'])->name('animals.live-search');
    Route::post('/animaux/{animal}/favori', [AnimalController::class, 'toggleFavorite'])->name('animals.favorite.toggle');

    Route::get('/animaux/{animal}/demande', [AdoptionRequestController::class, 'create'])->name('adoptions.create');
    Route::post('/animaux/{animal}/demande', [AdoptionRequestController::class, 'store'])->name('adoptions.store')->middleware('rate');
});
// je donne la route pour la page de gestion des utilisateurs, des roles et des permissions pour les administrateurs et les managers
//
Route::middleware(['auth', 'active', 'role:manager,admin'])->group(function () {
    Route::get('/manager/dashboard', [DashboardController::class, 'manager'])->name('manager.dashboard');
    Route::resource('animals', AnimalController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/demandes', [AdoptionRequestController::class, 'index'])->name('adoptions.index');
    Route::get('/adoptants', [DashboardController::class, 'adoptants'])->name('admin.adoptants.index');
    Route::get('/gestion/paiements', [DashboardController::class, 'paiements'])->name('admin.payments.index');
    Route::get('/gestion/paiements/{mobilePayment}/pdf', [MobilePaymentController::class, 'pdf'])->name('admin.payments.pdf');
    Route::get('/suivi-post-adoption', [DashboardController::class, 'suiviPostAdoption'])->name('admin.suivi.index');
    Route::get('/contenu/articles-conseils', [DashboardController::class, 'articlesConseils'])->name('admin.contenu.articles');
    Route::get('/contenu/pages', [DashboardController::class, 'pagesCms'])->name('admin.contenu.pages');
    Route::get('/contenu/nouveau', [ContenuCmsController::class, 'creer'])->name('admin.cms.create');
    Route::post('/contenu', [ContenuCmsController::class, 'enregistrer'])->name('admin.cms.store')->middleware('rate');
    Route::get('/contenu/{contenuCms}/modifier', [ContenuCmsController::class, 'modifier'])->name('admin.cms.edit');
    Route::put('/contenu/{contenuCms}', [ContenuCmsController::class, 'mettreAJour'])->name('admin.cms.update')->middleware('rate');
    Route::delete('/contenu/{contenuCms}', [ContenuCmsController::class, 'supprimer'])->name('admin.cms.destroy')->middleware('rate');
    Route::get('/utilisateurs', [GestionAdministrationController::class, 'listeUtilisateurs'])->name('admin.users.index');
    Route::get('/utilisateurs/{user}/modifier', [GestionAdministrationController::class, 'modifierUtilisateur'])->name('admin.users.edit');
    Route::put('/utilisateurs/{user}', [GestionAdministrationController::class, 'mettreAJourUtilisateur'])->name('admin.users.update')->middleware('rate');
    Route::get('/roles-permissions', [GestionAdministrationController::class, 'listeRolesPermissions'])->name('admin.roles.index');
    Route::post('/roles-permissions', [GestionAdministrationController::class, 'mettreAJourRolesPermissions'])->name('admin.roles.update')->middleware('rate');
    Route::get('/parametres', [GestionAdministrationController::class, 'listeParametres'])->name('admin.settings.index');
    Route::get('/tarification', [GestionAdministrationController::class, 'listeParametres'])->name('admin.pricing.index');
    Route::post('/parametres', [GestionAdministrationController::class, 'mettreAJourParametres'])->name('admin.settings.update')->middleware('rate');
    Route::post('/demandes/{adoptionRequest}/statut', [AdoptionRequestController::class, 'updateStatus'])->name('adoptions.status')->middleware('rate');
});
// je donne la route pour la page de gestion des utilisateurs, des roles et des permissions pour les administrateurs uniquement
Route::middleware(['auth', 'active', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/logs', [DashboardController::class, 'admin'])->name('admin.logs.index');
    Route::get('/admin/logs/search', [DashboardController::class, 'searchLogs'])->name('admin.logs.search');
    Route::patch('/admin/users/{user}/active', [DashboardController::class, 'toggleUserActive'])->name('admin.users.toggle')->middleware('rate');
    Route::delete('/admin/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy')->middleware('rate');
});
// je donne la route pour la page de gestion des paiements mobiles pour les administrateurs et les managers
Route::post('/paiements/labpay/callback', [MobilePaymentController::class, 'callback'])->name('payments.callback.labpay');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/conseils', [ContenuCmsController::class, 'pagePublique'])->name('cms.public.index');
});
