<?php

use App\Models\Doctor;
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
            $table->string('reg_number');
            $table->string('email');
            $table->string('practice_number');
            $table->bigInteger('vat_number')->nullable();
            $table->string('tele_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('street');
            $table->string('complex');
            $table->string('suburb');
            $table->string('city');
            $table->integer('code');
            $table->integer('has_entity');
            $table->integer('status')->default(Doctor::ACTIVE_STATUS);
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');
            $table->string('stock_scheme')->nullable();
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
