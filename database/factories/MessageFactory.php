<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    $user_ids = \App\User::pluck('id')->toArray();
    $fromUserId = $faker->randomElement($user_ids);
    $toUserId = $faker->randomElement($user_ids);
    $dialogId=$fromUserId>$toUserId?$fromUserId.'0000'.$toUserId:$toUserId.'0000'.$fromUserId;
    return [
        'body' => $faker->paragraph,
        'from_user_id' => $fromUserId,
        'to_user_id' => $toUserId,
        'has_read'=>"T",
        'dialog_id'=>$dialogId,
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
