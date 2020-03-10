<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Superheros::class, function (Faker $faker) {
    return [
        'heroname' => $faker->unique()->titleMale,
        'realname' => $faker->unique()->titleMale,
        'publisher' =>$faker->unique()->titleMale,
        'fadate' =>  now()
    ];
});
