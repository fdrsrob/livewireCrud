<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Students;
use Faker\Generator as Faker;

$factory->define(Students::class, function (Faker $faker) {
    return [
        'student_id' => $faker->unique()->numberBetween(100, 999),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
