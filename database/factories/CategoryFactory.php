<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'locale' => $this->faker->randomElement(['en', 'tr']),
        ];
    }

    public function withRandomParent()
    {
        if (rand(0, 1)) {
            return $this->state(function (array $attributes) {
                return array_merge($attributes, [
                    'parent_id' => Category::inRandomOrder()->first()->id,
                ]);
            });
        }
    }

    public function withParent()
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'parent_id' => Category::factory()->create()->id,
            ]);
        });
    }

}
