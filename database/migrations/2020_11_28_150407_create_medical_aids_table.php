<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_aids', function (Blueprint $table) {
            $table->id();
            $table->string('medical_name');
            $table->string('medical_aid_number');
            $table->string('medical_email_address');
            $table->string('plan')->nullable();
            $table->integer('medical_aid_status');
            $table->unsignedBigInteger('patient_id');
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
        Schema::dropIfExists('medical_aids');
    }
}
