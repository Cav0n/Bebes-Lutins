<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'url' => '/images/utils/question-mark.png',
        'name' => Str::random(10),
        'size' => $faker->numberBetween(100000, 500000)
    ];
});
