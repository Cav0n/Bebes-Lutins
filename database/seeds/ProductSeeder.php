<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 10)->create()->each(function ($product) {
            $product->images()->save(factory(App\Image::class)->make());
            $product->categories()->save(App\Category::all()->random());
        });
    }
}
