<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\ContenuCms;
use App\Models\FollowUp;
use App\Models\ParametreSysteme;
use App\Models\PermissionRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $administrateur = User::updateOrCreate([
            'email' => 'admin@exemple.com',
        ], [
            'nom' => 'Administrateur Principal',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'admin',
            'telephone' => '0812345678',
            'adresse' => 'Lubumbashi',
            'actif' => true,
        ]);

        $gestionnaire = User::updateOrCreate([
            'email' => 'gestionnaire@exemple.com',
        ], [
            'nom' => 'Gestionnaire de Test',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'manager',
            'telephone' => '0823456789',
            'adresse' => 'Kinshasa',
            'actif' => true,
        ]);

        $client = User::updateOrCreate([
            'email' => 'client@exemple.com',
        ], [
            'nom' => 'Client de Test',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'client',
            'telephone' => '0834567890',
            'adresse' => 'Goma',
            'actif' => true,
        ]);

        $milo = Animal::updateOrCreate([
            'nom' => 'Milo',
            'espece' => 'Chien',
        ], [
            'nom' => 'Milo',
            'espece' => 'Chien',
            'race' => 'Labrador',
            'age' => 3,
            'genre' => 'male',
            'taille' => 'medium',
            'description' => 'Chien affectueux et calme.',
            'localisation' => 'Lubumbashi',
            'statut' => 'disponible',
            'prix_adoption' => 150,
            'cree_par_utilisateur_id' => $administrateur->id,
        ]);

        Animal::updateOrCreate([
            'nom' => 'Luna',
            'espece' => 'Chat',
        ], [
            'nom' => 'Luna',
            'espece' => 'Chat',
            'race' => 'Siamois',
            'age' => 2,
            'genre' => 'female',
            'taille' => 'small',
            'description' => 'Chat tres sociable.',
            'localisation' => 'Kinshasa',
            'statut' => 'disponible',
            'prix_adoption' => 120,
            'cree_par_utilisateur_id' => $gestionnaire->id,
        ]);

        Animal::updateOrCreate([
            'nom' => 'Nala',
            'espece' => 'Chienne',
        ], [
            'nom' => 'Nala',
            'espece' => 'Chienne',
            'race' => 'Golden Retriever',
            'age' => 3,
            'genre' => 'female',
            'taille' => 'large',
            'description' => 'Energique, douce et parfaite pour une famille avec enfants.',
            'localisation' => 'Lubumbashi',
            'statut' => 'disponible',
            'prix_adoption' => 180,
            'cree_par_utilisateur_id' => $administrateur->id,
        ]);

        $demandeAdoption = AdoptionRequest::updateOrCreate([
            'utilisateur_id' => $client->id,
            'animal_id' => $milo->id,
        ], [
            'message' => 'Je souhaite adopter Milo. J\'ai de l\'experience avec les chiens et un espace adapte.',
            'statut' => 'en_attente',
            'notes' => 'Demande creee automatiquement pour les tests.',
        ]);

        FollowUp::updateOrCreate([
            'demande_adoption_id' => $demandeAdoption->id,
            'utilisateur_id' => $gestionnaire->id,
        ], [
            'notes' => 'Premier contact effectue avec le client.',
            'statut' => 'en_cours',
            'date_prochaine_etape' => now()->addDays(3)->toDateString(),
        ]);

        ActivityLog::updateOrCreate([
            'action' => 'creation_animal',
            'type_entite' => 'animal',
            'entite_id' => $milo->id,
        ], [
            'utilisateur_id' => $administrateur->id,
            'description' => 'L\'administrateur a cree la fiche de Milo.',
        ]);

        ActivityLog::updateOrCreate([
            'action' => 'creation_demande',
            'type_entite' => 'demande_adoption',
            'entite_id' => $demandeAdoption->id,
        ], [
            'utilisateur_id' => $client->id,
            'description' => 'Le client a soumis une demande d\'adoption pour Milo.',
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'preparer-l-arrivee-d-un-chien-a-la-maison',
        ], [
            'author_user_id' => $administrateur->id,
            'type' => 'article',
            'title' => 'Préparer l’arrivée d’un chien à la maison',
            'category' => 'Conseils adoption',
            'summary' => 'Checklist pratique pour sécuriser l’espace, organiser les accessoires et rassurer l’animal durant ses premiers jours.',
            'body' => 'Prévoir un panier, de l’eau, un espace calme et quelques repères simples pour faciliter l’adaptation du chien.',
            'status' => 'published',
            'is_featured' => true,
            'sort_order' => 1,
            'published_at' => now()->subDays(3),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'suivi-sante-apres-une-adoption-reussie',
        ], [
            'author_user_id' => $administrateur->id,
            'type' => 'article',
            'title' => 'Suivi santé après une adoption réussie',
            'category' => 'Suivi post-adoption',
            'summary' => 'Les bonnes pratiques pour planifier le premier contrôle vétérinaire et suivre l’adaptation alimentaire.',
            'body' => 'Le suivi doit inclure une visite vétérinaire, l observation des habitudes et la mise à jour des vaccinations.',
            'status' => 'published',
            'is_featured' => false,
            'sort_order' => 2,
            'published_at' => now()->subDays(2),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'prevoir-un-espace-calme',
        ], [
            'author_user_id' => $gestionnaire->id,
            'type' => 'conseil',
            'title' => 'Prévoir un espace calme',
            'category' => 'Conseil rapide',
            'summary' => 'Préparer une zone sécurisée avec eau, panier et jouets.',
            'body' => 'Un espace calme facilite la transition et réduit le stress de l animal dans les premiers jours.',
            'status' => 'published',
            'is_featured' => true,
            'sort_order' => 1,
            'published_at' => now()->subDay(),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'maintenir-un-rythme-stable',
        ], [
            'author_user_id' => $gestionnaire->id,
            'type' => 'conseil',
            'title' => 'Maintenir un rythme stable',
            'category' => 'Conseil rapide',
            'summary' => 'Conserver des horaires réguliers pour les repas et les sorties.',
            'body' => 'Des routines stables permettent à l animal de s adapter plus vite et à la famille de rester cohérente.',
            'status' => 'published',
            'is_featured' => false,
            'sort_order' => 2,
            'published_at' => now()->subDay(),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'accueil',
        ], [
            'author_user_id' => $administrateur->id,
            'type' => 'page',
            'title' => 'Accueil',
            'category' => 'Page vitrine',
            'summary' => 'Page d’accueil principale du site.',
            'body' => 'Accueil du site avec mise en avant des animaux, des conseils et des appels à l action.',
            'status' => 'published',
            'is_featured' => true,
            'sort_order' => 1,
            'published_at' => now()->subDays(5),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'processus-d-adoption',
        ], [
            'author_user_id' => $administrateur->id,
            'type' => 'page',
            'title' => 'Processus d’adoption',
            'category' => 'Page éditoriale',
            'summary' => 'Présentation du parcours d adoption.',
            'body' => 'Cette page détaille les étapes, les validations et le suivi après adoption.',
            'status' => 'published',
            'is_featured' => false,
            'sort_order' => 2,
            'published_at' => now()->subDays(4),
        ]);

        ContenuCms::updateOrCreate([
            'slug' => 'faq',
        ], [
            'author_user_id' => $gestionnaire->id,
            'type' => 'page',
            'title' => 'FAQ',
            'category' => 'Page support',
            'summary' => 'Réponses aux questions fréquentes.',
            'body' => 'Regroupe les réponses utiles sur l adoption, les paiements et le suivi.',
            'status' => 'draft',
            'is_featured' => false,
            'sort_order' => 3,
            'published_at' => null,
        ]);

        $permissions = [
            'users.view' => true,
            'users.edit' => true,
            'users.delete' => true,
            'users.toggle' => true,
            'animals.manage' => true,
            'adoptions.manage' => true,
            'cms.manage' => true,
            'settings.manage' => true,
        ];

        foreach (['admin', 'manager', 'client'] as $role) {
            foreach ($permissions as $permission => $enabled) {
                PermissionRole::updateOrCreate([
                    'role' => $role,
                    'permission' => $permission,
                ], [
                    'enabled' => $role === 'admin' ? true : ($role === 'manager' ? in_array($permission, ['users.view', 'users.edit', 'users.toggle', 'animals.manage', 'adoptions.manage', 'cms.manage'], true) : false),
                ]);
            }
        }

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'app_name',
        ], [
            'setting_label' => 'Nom de l application',
            'setting_value' => 'Adopte un ami',
            'setting_type' => 'text',
            'setting_group' => 'general',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'support_email',
        ], [
            'setting_label' => 'Email support',
            'setting_value' => 'support@exemple.com',
            'setting_type' => 'email',
            'setting_group' => 'general',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'support_phone',
        ], [
            'setting_label' => 'Téléphone support',
            'setting_value' => '0812345678',
            'setting_type' => 'text',
            'setting_group' => 'general',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'support_address',
        ], [
            'setting_label' => 'Adresse support',
            'setting_value' => 'Lubumbashi',
            'setting_type' => 'text',
            'setting_group' => 'general',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'maintenance_mode',
        ], [
            'setting_label' => 'Mode maintenance',
            'setting_value' => '0',
            'setting_type' => 'boolean',
            'setting_group' => 'system',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'default_language',
        ], [
            'setting_label' => 'Langue par défaut',
            'setting_value' => 'fr',
            'setting_type' => 'text',
            'setting_group' => 'system',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'publication_default_status',
        ], [
            'setting_label' => 'Statut de publication par défaut',
            'setting_value' => 'draft',
            'setting_type' => 'text',
            'setting_group' => 'cms',
        ]);

        ParametreSysteme::updateOrCreate([
            'setting_key' => 'default_adoption_fee',
        ], [
            'setting_label' => 'Frais d adoption par défaut',
            'setting_value' => '100',
            'setting_type' => 'decimal',
            'setting_group' => 'tarification',
        ]);
    }
}
