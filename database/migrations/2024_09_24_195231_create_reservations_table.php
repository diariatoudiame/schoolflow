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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id'); // Déclaration explicite de la colonne pour la clé étrangère
            $table->unsignedBigInteger('user_id'); // Déclaration explicite de la colonne pour la clé étrangère
            $table->date('reservation_date');
            $table->integer('duration')->default(7);
            $table->timestamps();

            // Définition des clés étrangères
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
