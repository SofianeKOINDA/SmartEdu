<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('echeance_id')->constrained('echeances')->onDelete('restrict');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('restrict');
            $table->string('reference', 100)->unique();
            $table->decimal('montant', 10, 2);
            $table->enum('statut', ['initie', 'succes', 'echec', 'annule'])->default('initie');
            $table->string('paytech_token')->nullable();
            $table->string('paytech_ref')->nullable();
            $table->dateTime('paye_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
