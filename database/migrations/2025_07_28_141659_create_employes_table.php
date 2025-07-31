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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->char('sexe');
            $table->string('email')->unique();
            $table->string('contact')->unique();
            $table->string('addresse')->nullable();
            $table->string('entreprise_access_token');
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->foreign('entreprise_access_token')->references('access_token')->on('entreprises')->onDelete('cascade');
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
