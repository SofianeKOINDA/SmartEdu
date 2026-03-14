<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('echeances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('tarif_id')->constrained('tarifs')->onDelete('cascade');
            $table->integer('numero_mois');
            $table->decimal('montant', 10, 2);
            $table->date('date_limite');
            $table->enum('statut', ['en_attente', 'paye', 'retard'])->default('en_attente');
            $table->timestamps();

            $table->unique(['etudiant_id', 'tarif_id', 'numero_mois']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('echeances');
    }
};
