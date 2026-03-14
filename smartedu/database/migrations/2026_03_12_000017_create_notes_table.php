<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('saisi_par')->constrained('users')->onDelete('restrict');
            $table->decimal('valeur', 5, 2);
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique(['evaluation_id', 'etudiant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
