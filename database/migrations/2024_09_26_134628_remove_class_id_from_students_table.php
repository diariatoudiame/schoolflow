<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveClassIdFromStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère si elle existe
            $table->dropForeign(['class_id']); // Nom de la colonne à supprimer
            // Supprimer la colonne
            $table->dropColumn('class_id');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable(); // Restaurez-la si besoin
        });
    }
}
