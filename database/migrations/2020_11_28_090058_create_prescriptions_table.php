<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_product_id');
            $table->unsignedBigInteger('appointment_id');
            $table->integer('quantity');
            $table->string('days');
            $table->integer('morning_time')->default(0);
            $table->integer('afternoon_time')->default(0);
            $table->integer('evening_time')->default(0);
            $table->integer('night_time')->default(0);
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
        Schema::dropIfExists('prescriptions');
    }
}
