<?php

use App\Want;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Want::class, function (Faker $faker) {
    $title = $faker->randomElement(['Add', 'Fix', 'Improve']).' '.implode(' ', $faker->words(rand(2, 5)));

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'status' => $faker->randomElement([
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Requested',
            'Planned',
            'Completed',
            'Completed',
        ]),
    ];
});
