<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpecialitiesScreeningQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialities_screening_questionnaire', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialities_id');
            $table->unsignedBigInteger('screening_questionnaire_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialities_screening_questionnaire');
    }
}
