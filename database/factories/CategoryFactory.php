<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = Str::random(10);
    static $rank = 1;
    return [
        'id' => strtolower($name),
        'name' => $name,
        'description' => $faker->text,
        'rank' => $rank++,
    ];
});
