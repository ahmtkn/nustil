<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuPositionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('nustil.menu_positions') as $position) {
            foreach (getLocales() as $locale => $localeName) {
                app()->setLocale($locale);
                \App\Models\Menu::create([
                    'method' => 'route',
                    'locale' => $locale,
                    'group' => $position,
                    'title' => __('Home'),
                    'to' => 'landing',
                    'payload' => [],
                ]);
            }
        }
    }

}
