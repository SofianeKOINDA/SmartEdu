<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions_pedagogiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->date('date_inscription')->nullable();
            $table->timestamps();

            $table->unique(['etudiant_id', 'cours_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions_pedagogiques');
    }
};
