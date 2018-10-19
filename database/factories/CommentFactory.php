<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $user_ids=\App\User::pluck('id')->toArray();
    $article_ids=\App\Article::pluck('id')->toArray();
    $commentable_type=['App\Article','App\Instalment'];
    return [
        'body' => $faker->paragraph,
        'user_id' => $faker->randomElement($user_ids),
        'commentable_id' => $faker->randomElement($article_ids),
        'commentable_type'=> $faker->randomElement($commentable_type),
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
