<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliberations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->enum('decision', ['admis', 'rattrapage', 'redoublant', 'exclus', 'en_attente'])->default('en_attente');
            $table->text('observation')->nullable();
            $table->foreignId('delibere_par')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('delibere_le')->nullable();
            $table->timestamps();

            $table->unique(['etudiant_id', 'semestre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliberations');
    }
};
