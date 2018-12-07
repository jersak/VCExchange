<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Notification::class, function (Faker $faker) {
    return [
        'to_user' => User::inRandomOrder()->first()->id,
        'notification_type_id' => 1,
        'is_read' => rand(0, 1),
    ];
});
