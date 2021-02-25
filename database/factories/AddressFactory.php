<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'postal_code' => rand(10000, 50000),
        'address_type_id' => 1,
        'province_id' => rand(1,9)
    ];
});
