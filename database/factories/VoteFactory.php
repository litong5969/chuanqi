<?php

use Faker\Generator as Faker;

$factory->define(App\Vote::class, function (Faker $faker) {
    $user_ids = \App\User::pluck('id')->toArray();
    $instalment = \App\Instalment::pluck('id')->toArray();
    return [
        'instalment_id' => $instalment,
        'user_id' => $user_ids,
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
