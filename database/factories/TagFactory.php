<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'bio' => $faker->paragraph,
        'articles_count'=>1,
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
