<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\View;
use Faker\Generator as Faker;

$factory->define(View::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 11800),
        'user_ip' => $faker->ipv4
    ];
});
