<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
        $locale = App::getLocale();
        $locales = getLocales();

        Blade::directive('menu', function (string $menu) {
            return "<?php echo \App\Models\Menu::prepare({$menu})->render(); ?>";
        });

        View::composer('*', function ($view) use ($locale, $locales) {
            $view->with([
                'settings' => cache()->remember('settings', 86400, fn() => app(GeneralSettings::class)),
                'locale' => $locale,
                'locales' => $locales,
                'colors' => [
                    'slate',
                    'gray',
                    'zinc',
                    'neutral',
                    'stone',
                    'red',
                    'orange',
                    'amber',
                    'yellow',
                    'lime',
                    'green',
                    'emerald',
                    'teal',
                    'cyan',
                    'sky',
                    'blue',
                    'indigo',
                    'violet',
                    'purple',
                    'fuchsia',
                    'pink',
                    'rose',
                ],
            ]);
        });

        setlocale(LC_TIME, $locales[$locale]);
        Carbon::setLocale($locale.'_'.strtoupper($locale));
    }

}
