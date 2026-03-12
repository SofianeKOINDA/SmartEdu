<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annees_scolaires')->onDelete('restrict');
            $table->decimal('montant_total', 10, 2);
            $table->integer('nombre_echeances')->default(9);
            $table->integer('jour_limite')->default(5);
            $table->foreignId('cree_par')->constrained('users')->onDelete('restrict');
            $table->timestamps();

            $table->unique(['tenant_id', 'annee_scolaire_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};
