<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->string('intitule');
            $table->enum('type', ['devoir', 'examen', 'tp', 'projet', 'autre'])->default('devoir');
            $table->decimal('coefficient', 4, 2)->default(1);
            $table->decimal('note_max', 5, 2)->default(20);
            $table->date('date_evaluation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
