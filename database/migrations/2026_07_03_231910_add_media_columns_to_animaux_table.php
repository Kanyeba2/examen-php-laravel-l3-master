<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animaux', function (Blueprint $table) {
            $table->string('chemin_document')->nullable()->after('chemin_image');
            $table->string('chemin_image_miniature')->nullable()->after('chemin_document');
        });
    }

    public function down(): void
    {
        Schema::table('animaux', function (Blueprint $table) {
            $table->dropColumn(['chemin_document', 'chemin_image_miniature']);
        });
    }
};
