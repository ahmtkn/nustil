<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 10));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => implode(PHP_EOL, $this->faker->paragraphs(rand(3, 10))),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => $this->faker->dateTimeBetween('-1 year'),
            'tags' => implode(',', $this->faker->words(rand(1, 5))),
            'locale' => $this->faker->randomElement(array_keys(getLocales())),
        ];
    }

}
