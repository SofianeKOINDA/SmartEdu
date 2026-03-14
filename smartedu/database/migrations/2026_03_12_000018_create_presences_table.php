<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('saisi_par')->constrained('users')->onDelete('restrict');
            $table->date('date_seance');
            $table->enum('statut', ['present', 'absent', 'retard', 'excuse'])->default('present');
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->unique(['cours_id', 'etudiant_id', 'date_seance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
