<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Appointment;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'patient_id' => rand(1,400),
        'doctor_id' => rand(1,400),
        'appointment_date' => Carbon::now(),
        'appointment_time' => Carbon::now()->addHours(1),
        'status' => Appointment::PENDING_STATUS,
        'clinic_id' => rand(1,4),
    ];
});
