<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->json('reponses');
            $table->foreignId('assure_id')->constrained('assures')->onDelete('cascade');
            $table->string('statut')->default('en attente');
            $table->foreignId('gestionnaire_id')->constrained('gestionnaires')->onDelete('cascade');
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
