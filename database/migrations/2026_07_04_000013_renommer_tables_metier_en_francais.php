<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cms_contents')) {
            Schema::rename('cms_contents', 'contenus_cms');
        }

        if (Schema::hasTable('system_settings')) {
            Schema::rename('system_settings', 'parametres_systeme');
        }

        if (Schema::hasTable('role_permissions')) {
            Schema::rename('role_permissions', 'permissions_roles');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contenus_cms')) {
            Schema::rename('contenus_cms', 'cms_contents');
        }

        if (Schema::hasTable('parametres_systeme')) {
            Schema::rename('parametres_systeme', 'system_settings');
        }

        if (Schema::hasTable('permissions_roles')) {
            Schema::rename('permissions_roles', 'role_permissions');
        }
    }
};
