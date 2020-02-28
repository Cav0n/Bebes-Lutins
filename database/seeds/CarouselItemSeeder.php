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
        for ($i = 1; $i <= 3; $i++) {
            $image = factory(App\Image::class)->create(['url' => 'images/carousel/'.$i.'.jpg']);
            factory(App\CarouselItem::class, 1)->create(['image_id' => $image->id]);
        }
    }
}
