<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
        {
            Schema::create('classe_cours', function (Blueprint $table) {
                $table->id();
                $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
                $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
                $table->unique(['classe_id', 'cours_id']);   // Assure que chaque cours est associé à une classe de manière unique
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_cours');
    }
};
