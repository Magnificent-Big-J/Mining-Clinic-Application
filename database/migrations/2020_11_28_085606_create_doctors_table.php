<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('entity_name');
            $table->string('entity_status');
            $table->string('reg_number');
            $table->string('email');
            $table->string('practice_number');
            $table->bigInteger('vat_number');
            $table->string('tele_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('user_id');
            $table->string('stock_scheme');
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
        Schema::dropIfExists('doctors');
    }
}
