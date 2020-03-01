<?php

use Illuminate\Database\Seeder;

class CarouselItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indir = array_filter(scandir(public_path('images/carousel/')), function($item) {
            return !is_dir('../pages/' . $item) && $item != '.' && $item != '..';
        });

        foreach ($indir as $item) {
            $image = factory(App\Image::class)->create(['url' => 'images/carousel/'.$item]);
            factory(App\CarouselItem::class, 1)->create(['image_id' => $image->id]);
        }
    }
}
