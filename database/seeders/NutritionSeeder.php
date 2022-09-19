<?php

namespace Database\Seeders;

use App\Models\Nutrition;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('nustil.nutritions') as $nutrition => $unit) {
            Nutrition::create([
                'name' => $nutrition,
                'unit' => $unit,
            ]);
        }
    }

}
