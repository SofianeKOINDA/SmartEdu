<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->string('nom');
            $table->string('code')->nullable();
            $table->decimal('coefficient', 4, 2)->default(1);
            $table->integer('credit')->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'semestre_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ues');
    }
};
