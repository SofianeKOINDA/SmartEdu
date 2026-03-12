<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annees_scolaires')->onDelete('cascade');
            $table->string('nom');
            $table->integer('numero');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('actif')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'annee_scolaire_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
