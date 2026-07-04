<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('demande_adoption_id')->nullable()->constrained('demandes_adoption')->nullOnDelete();
            $table->string('fournisseur', 30);
            $table->decimal('montant', 10, 2);
            $table->string('devise', 10)->default('USD');
            $table->string('numero_telephone', 30);
            $table->string('reference_interne')->unique();
            $table->string('reference_fournisseur')->nullable();
            $table->string('statut', 20)->default('en_attente');
            $table->json('payload_initiation')->nullable();
            $table->json('payload_confirmation')->nullable();
            $table->timestamp('recu_envoye_at')->nullable();
            $table->timestamps();

            $table->index(['statut', 'fournisseur']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_payments');
    }
};
