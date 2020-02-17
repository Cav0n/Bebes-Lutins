<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    $name = Str::random(10);
    $reference = $faker->numberBetween(0, 10000);
    return [
        'id' => strtolower($name),
        'reference' => str_pad($reference, 5, "0", STR_PAD_LEFT),
        'name' => $name,
        'description' => $faker->text,
        'price' => $faker->numberBetween(1.00, 200.00),
        'stock' => $faker->numberBetween(10, 1000)
    ];
});
