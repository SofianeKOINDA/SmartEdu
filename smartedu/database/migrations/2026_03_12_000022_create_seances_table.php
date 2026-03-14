<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->string('salle', 50)->nullable();
            $table->enum('jour', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('type', ['cm', 'td', 'tp'])->default('cm');
            $table->boolean('recurrent')->default(true);
            $table->date('date_specifique')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'salle', 'jour', 'heure_debut'], 'uq_salle_horaire');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
