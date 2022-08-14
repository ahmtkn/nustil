<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
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
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
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
            return "<?php echo \App\Models\Menu::prepare(".$menu.")->render(); ?>";
        });
        \View::composer('*', function ($view) use ($locale, $locales) {
            $view->with(
                'settings',
                cache()->remember('settings', 86400, function () {
                    return app(GeneralSettings::class);
                })
            );
            $view->with('locale', $locale);
            $view->with('locales', $locales);
            $view->with(
                'colors',
                [
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
                ]
            );
        });

        setlocale(LC_TIME, $locales[$locale]);
        Carbon::setLocale($locale.'_'.strtoupper($locale));
//        dd(Carbon::getLocale());
    }

}
