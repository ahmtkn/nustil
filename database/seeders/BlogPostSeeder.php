<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogPost::factory(150)->create()->each(function ($post) {
            $post->categories()->attach(BlogCategory::inRandomOrder()->first());
        });
    }

}
