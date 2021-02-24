<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking_details', function (Blueprint $table) {
            $table->id();
            $table->string('acc_holder');
            $table->string('bank_name');
            $table->bigInteger('acc_number');
            $table->integer('branch_code');
            $table->softDeletes();
            $table->unsignedBigInteger('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banking_details');
    }
}
