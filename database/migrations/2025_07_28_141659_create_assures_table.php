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
        Schema::create('assures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->char('sexe',1);
            $table->string('email')->unique();
            $table->string('contact')->unique();
            $table->string('addresse')->nullable();
            $table->string('client_access_token');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('statut')->default('en attente');
            $table->string('anciennete')->nullable();
            $table->dateTime('date_naissance')->nullable();
            $table->foreign('client_access_token')->references('access_token')->on('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_principal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
