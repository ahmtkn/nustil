<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Nutrition;
use Illuminate\Support\Facades\File;
use App\Models\Pivots\NutritionProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(5,true),
            'slug' => $this->faker->slug,
            'color' => $this->faker->hexColor,
            'weight' => $this->faker->randomFloat(2, 0, 100),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'is_pack' => $this->faker->boolean,
            'locale' => $this->faker->randomElement(array_keys(getLocales())),
            'tagline' => $this->faker->sentence,
            'description' => $this->faker->text,
            'status' => 'published',
            'purchase_link' => $this->faker->url,
        ];
    }

    public function withNutritions()
    {
        return $this->afterCreating(function ($product) {
            $product->nutritions()->saveMany(function () {
                $coll = new Collection();
                foreach (Nutrition::all() as $nutrition) {
                    $coll->add(
                        (new NutritionProduct([
                            'value' => $this->faker->randomFloat(2, 0, 100),
                        ]))->nutrition()->associate($nutrition)
                    );
                }

                return $coll;
            });
        });
    }

    public function withCategories()
    {
        return $this->afterCreating(function ($product) {
            $randCategories = Category::locale($product->locale)->inRandomOrder()->get()->take(rand(1, 5));
            $product->categories()->saveMany($randCategories);
        });
    }

    public function withDummyImage()
    {
        return $this->afterCreating(function ($product) {
            $path = "uploads\dummy\\";
            $file = collect(File::allFiles(storage_path("app\\".$path)))->shuffle()->take(1)->first();
            $filePath = $path.$file->getFilename();

            $product->image()->create([
                'path' => $filePath,
                'name' => $file->getFilename(),
                'mime_type' => 'image/'.$file->getExtension(),
                'type' => 'image',
            ]);
        });
    }

}
