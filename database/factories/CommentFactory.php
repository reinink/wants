<?php

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-10 years', 'now');

    return [
        'comment' => $faker->sentences(rand(1, 6), true),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
