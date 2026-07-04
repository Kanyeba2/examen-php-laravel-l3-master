<?php

namespace App\Http\Controllers;

use App\Models\RolePermission as PermissionRole;
use App\Models\ParametreSysteme;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GestionAdministrationController extends Controller
{
    // Centralise la gestion des utilisateurs, roles et parametres systeme.
    private const ROLES = ['client', 'manager', 'admin'];

    private const PERMISSIONS = [
        'users.view' => 'Voir les utilisateurs',
        'users.edit' => 'Modifier les utilisateurs',
        'users.delete' => 'Supprimer les utilisateurs',
        'users.toggle' => 'Activer ou désactiver les utilisateurs',
        'animals.manage' => 'Gérer les animaux',
        'adoptions.manage' => 'Gérer les demandes d adoption',
        'cms.manage' => 'Gérer les contenus',
        'settings.manage' => 'Gérer les paramètres',
    ];

    public function listeUtilisateurs(): View
    {
        $compteurs = collect(self::ROLES)->mapWithKeys(function (string $role) {
            return [$role => User::where('role', $role)->count()];
        });

        $clients = User::where('role', 'client')->latest()->paginate(6, ['*'], 'clients_page');
        $gestionnaires = User::where('role', 'manager')->latest()->paginate(6, ['*'], 'managers_page');
        $administrateurs = User::where('role', 'admin')->latest()->paginate(6, ['*'], 'admins_page');

        return view('admin.users.index', compact('compteurs', 'clients', 'gestionnaires', 'administrateurs'));
    }

    public function modifierUtilisateur(User $utilisateur): View
    {
        return view('admin.users.edit', compact('utilisateur'));
    }

    public function mettreAJourUtilisateur(Request $request, User $utilisateur): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:180'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email,'.$utilisateur->id],
            'telephone' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:client,manager,admin'],
            'actif' => ['nullable', 'boolean'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $donnees['actif'] = $request->boolean('actif');
        $donnees['two_factor_enabled'] = $request->boolean('two_factor_enabled');

        $utilisateur->update($donnees);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function listeRolesPermissions(): View
    {
        $permissions = collect(self::PERMISSIONS);
        $matrice = [];

        foreach (self::ROLES as $role) {
            foreach (self::PERMISSIONS as $permission => $label) {
                $matrice[$role][$permission] = PermissionRole::where('role', $role)
                    ->where('permission', $permission)
                    ->value('enabled') ?? $this->etatPermissionParDefaut($role, $permission);
            }
        }

        return view('admin.roles-permissions', compact('permissions', 'matrice'));
    }

    public function mettreAJourRolesPermissions(Request $request): RedirectResponse
    {
        $donnees = $request->input('permissions', []);

        foreach (self::ROLES as $role) {
            foreach (self::PERMISSIONS as $permission => $label) {
                $enabled = (bool) data_get($donnees, $role.'.'.$permission, false);

                PermissionRole::updateOrCreate(
                    ['role' => $role, 'permission' => $permission],
                    ['enabled' => $enabled]
                );
            }
        }

        return back()->with('success', 'Permissions mises à jour avec succès.');
    }

    public function listeParametres(): View
    {
        $parametres = $this->carteDesParametres();

        return view('admin.settings', compact('parametres'));
    }

    public function mettreAJourParametres(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'app_name' => ['required', 'string', 'max:120'],
            'support_email' => ['required', 'email', 'max:180'],
            'support_phone' => ['nullable', 'string', 'max:30'],
            'support_address' => ['nullable', 'string', 'max:255'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'default_language' => ['required', 'string', 'max:10'],
            'publication_default_status' => ['required', 'in:draft,published'],
            'default_adoption_fee' => ['required', 'numeric', 'min:0'],
        ]);

        $this->enregistrerParametre('app_name', 'Nom de l application', $donnees['app_name'], 'text', 'general');
        $this->enregistrerParametre('support_email', 'Email support', $donnees['support_email'], 'email', 'general');
        $this->enregistrerParametre('support_phone', 'Téléphone support', $donnees['support_phone'] ?? '', 'text', 'general');
        $this->enregistrerParametre('support_address', 'Adresse support', $donnees['support_address'] ?? '', 'text', 'general');
        $this->enregistrerParametre('maintenance_mode', 'Mode maintenance', $request->boolean('maintenance_mode') ? '1' : '0', 'boolean', 'system');
        $this->enregistrerParametre('default_language', 'Langue par défaut', $donnees['default_language'], 'text', 'system');
        $this->enregistrerParametre('publication_default_status', 'Statut de publication par défaut', $donnees['publication_default_status'], 'text', 'cms');
        $this->enregistrerParametre('default_adoption_fee', 'Frais d adoption par défaut', (string) $donnees['default_adoption_fee'], 'decimal', 'tarification');

        return back()->with('success', 'Paramètres enregistrés avec succès.');
    }

    public function usersIndex(): View
    {
        return $this->listeUtilisateurs();
    }

    public function editUser(User $user): View
    {
        return $this->modifierUtilisateur($user);
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        return $this->mettreAJourUtilisateur($request, $user);
    }

    public function rolesPermissionsIndex(): View
    {
        return $this->listeRolesPermissions();
    }

    public function updateRolesPermissions(Request $request): RedirectResponse
    {
        return $this->mettreAJourRolesPermissions($request);
    }

    public function settingsIndex(): View
    {
        return $this->listeParametres();
    }

    public function settingsUpdate(Request $request): RedirectResponse
    {
        return $this->mettreAJourParametres($request);
    }

    private function carteDesParametres(): array
    {
        return [
            'app_name' => ParametreSysteme::obtenirValeur('app_name', config('app.name')),
            'support_email' => ParametreSysteme::obtenirValeur('support_email', 'support@exemple.com'),
            'support_phone' => ParametreSysteme::obtenirValeur('support_phone', ''),
            'support_address' => ParametreSysteme::obtenirValeur('support_address', ''),
            'maintenance_mode' => ParametreSysteme::obtenirValeur('maintenance_mode', '0') === '1',
            'default_language' => ParametreSysteme::obtenirValeur('default_language', 'fr'),
            'publication_default_status' => ParametreSysteme::obtenirValeur('publication_default_status', 'draft'),
            'default_adoption_fee' => ParametreSysteme::obtenirValeur('default_adoption_fee', '100'),
        ];
    }

    private function enregistrerParametre(string $cle, string $libelle, string $valeur, string $type, string $groupe): void
    {
        ParametreSysteme::updateOrCreate(
            ['setting_key' => $cle],
            [
                'setting_label' => $libelle,
                'setting_value' => $valeur,
                'setting_type' => $type,
                'setting_group' => $groupe,
            ]
        );
    }

    private function etatPermissionParDefaut(string $role, string $permission): bool
    {
        return match ($role) {
            'admin' => true,
            'manager' => in_array($permission, ['users.view', 'users.edit', 'users.toggle', 'animals.manage', 'adoptions.manage', 'cms.manage'], true),
            default => false,
        };
    }
}
