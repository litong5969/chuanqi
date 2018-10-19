<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar'=>$faker->imageUrl(256,256),
        'password' => '$2y$10$bxRQ0ltaUk.DwyLgp6W4I.PlKdGIxbkUDUfnbSUd5XSkrXmsRmVey', // 123123
        'confirmation_token' => str_random(50),
        'api_token' => str_random(60),
        'is_active'=>'1',
        'settings'=>[ 'bio'=>$faker->sentence,'weibo'=>$faker->name,'weibo_url'=>$faker->url]
        ];

});


