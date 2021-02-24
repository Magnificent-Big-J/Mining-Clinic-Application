<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_fee_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->date('assessment_date');
            $table->softDeletes();
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
        Schema::dropIfExists('appointment_assessments');
    }
}
