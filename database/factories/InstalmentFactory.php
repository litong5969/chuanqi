<?php

use Faker\Generator as Faker;

$factory->define(App\Instalment::class, function (Faker $faker) {
    $user_ids = \App\User::pluck('id')->toArray();
    $article_ids = \App\Article::pluck('id')->toArray();
    $instalment_ids = \App\Instalment::pluck('id')->toArray();
   $instalment=[
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'article_id' => $faker->randomElement($article_ids),
        'votes_count'=>$faker->numberBetween(1,1000),
        'leg'=>$faker->numberBetween(1,10),
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
    return $instalment;
});
