<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annees_scolaires')->onDelete('cascade');
            $table->string('nom');
            $table->integer('niveau');
            $table->timestamps();

            $table->unique(['tenant_id', 'filiere_id', 'annee_scolaire_id', 'niveau']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
