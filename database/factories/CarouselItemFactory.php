<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CarouselItem;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(CarouselItem::class, function (Faker $faker) {
    $title = Str::random(10);
    static $rank = 1;
    return [
        'title' => $title,
        'description' => $faker->text,
        'link' => '#',
        'rank' => $rank++,
    ];
});
