<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Nutrition;
use Spatie\Permission\Models\Role;
use Spatie\LaravelSettings\Settings;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            NutritionSeeder::class,
            MenuPositionsSeeder::class,
        ]);
        $user = User::factory(1)->email('uutkukorkmaz@gmail.com')->password('123')->create()->first();
        foreach (Permission::all() as $perm) {
            $user->givePermissionTo($perm);
        }
        $this->seedDummyData();
    }

    public function seedDummyData()
    {
        if (!app()->isProduction()) {
            $cli = new ConsoleOutput();
            $cli->write('Seeding dummy data...'.PHP_EOL);
            Category::factory(5)->create()->each(function ($category) {
                $category->children()->saveMany(Category::factory(rand(0, 5))->create());
            });

            $this->call([
                BlogCategorySeeder::class,
                BlogPostSeeder::class,
                ProductSeeder::class,
                PageSeeder::class,
            ]);

            User::factory(20)->create();
            cache()->flush();
        }
    }

}
