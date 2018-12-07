<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Transaction::class, function (Faker $faker) {
    return [
        'from_user' => User::inRandomOrder()->first()->id,
        'to_user' => User::inRandomOrder()->first()->id,
        'amount' => $faker->randomFloat(2, 0, 1000),
        'note' => $faker->sentence(3),
    ];
});
