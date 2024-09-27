<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('course_time'); // Supprimer l'ancienne colonne
            $table->time('start_time')->after('day_of_week'); // Ajouter l'heure de début
            $table->time('end_time')->after('start_time');    // Ajouter l'heure de fin
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']); // Supprimer les nouvelles colonnes
            $table->time('course_time')->after('day_of_week'); // Restaurer l'ancienne colonne si besoin
        });
    }
}
