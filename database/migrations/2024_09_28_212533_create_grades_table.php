<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Lien avec la table students
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Lien avec la table subjects
            $table->string('evaluation_type'); // Type d'évaluation (ex. examen, devoir)
            $table->decimal('grade', 5, 2); // Note avec deux décimales
            $table->text('comment')->nullable(); // Champ commentaire
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
