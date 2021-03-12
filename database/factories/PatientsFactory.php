<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\Models\Patient::class, function (Faker $faker) {
    $gender = array('Male', 'Female');
    $selectedGender = $gender[rand(0,1)];
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'second_name' => $faker->name,
        'gender' => $selectedGender,
        'date_of_birth' => Carbon::now()->subYear(20),
        'identity_number' => '0108245304098',
        'is_south_african' => true,
        'work_number' => '',
        'landline' => '',
        'cell_number' => '0' . rand(6,8) . rand(0,8) . rand(1000,9999) . rand(100,999),
        'has_medical_aid' => false,
        'email_address' => $faker->unique()->safeEmail,
    ];
});
