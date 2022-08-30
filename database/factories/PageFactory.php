<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'locale' => $this->faker->randomElement(array_keys(getLocales())),
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->randomHtml(2, 3),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
            'deleted_at' => rand(1, 10) == 1
                ? $this->faker->dateTimeBetween('-1 year')
                : null,
        ];
    }

}
