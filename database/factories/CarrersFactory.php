<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Carrera;
use Faker\Generator as Faker;

$factory->define(Carrera::class, function (Faker $faker) {
    return [
        //'code' => $faker->unique()->numberBetween(1000, 9999),
        'racer_name' => $this->faker->word,
        'description' => $this->faker->sentence,
    ];
});
