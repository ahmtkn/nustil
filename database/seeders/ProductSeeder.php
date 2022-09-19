<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;
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
        $products = Product::factory(20)
            ->withNutritions()
            ->withCategories()
//            ->withDummyImage()
            ->create();
    }


}
