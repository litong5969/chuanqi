<?php

use Faker\Generator as Faker;

$factory->define(App\Instalment::class, function (Faker $faker) {
    $user_ids = \App\User::pluck('id')->toArray();
    $article_ids = \App\Article::pluck('id')->toArray();
    return [
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'article_id' => $faker->randomElement($article_ids),
        'votes_count'=>$faker->numberBetween(1,2000),
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
