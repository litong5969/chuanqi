<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $user_ids=\App\User::pluck('id')->toArray();
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'votes_count'=>$faker->numberBetween(5000,20000),
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
