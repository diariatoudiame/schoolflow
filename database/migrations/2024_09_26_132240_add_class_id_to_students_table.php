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
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('user_id'); // Ajoutez cette ligne pour class_id
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null'); // Ajoutez cette ligne pour la clé étrangère
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['class_id']);
            // Supprimer la colonne class_id
            $table->dropColumn('class_id');
        });
    }
};
