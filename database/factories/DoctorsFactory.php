<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
    return [
        'reg_number' => rand(10000000, 20000000),
        'email' => $faker->unique()->safeEmail,
        'practice_number' => rand(10000000, 20000000),
        'status' => Doctor::ACTIVE_STATUS,
        'vat_number' => rand(10000000, 20000000),
        'tele_number' => $faker->phoneNumber,
        'fax_number'  => $faker->phoneNumber,
        'complex' => $faker->address,
        'suburb' => $faker->address,
        'city' => $faker->address,
        'has_entity' => Doctor::No_ENTITY_STATE,
        'code' => rand(10000, 50000),

    ];
});
