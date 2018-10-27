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
        'votes_count'=>$faker->numberBetween(1,2000),
        'leg'=>$faker->numberBetween(1,10),
        'prev_instalment'=>$faker->randomElement($instalment_ids),
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
   $instalment['votes_count_all']=$instalment['leg']*12345;
    return $instalment;
});
