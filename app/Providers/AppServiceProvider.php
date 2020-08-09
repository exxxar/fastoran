<?php

namespace App\Providers;

use App\Parts\Models\Fastoran\Section;
use App\Parts\Models\Fastoran\MenuCategory;
use App\Parts\Models\Fastoran\Restoran;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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

        Schema::defaultStringLength(191);


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        date_default_timezone_set("Europe/Moscow");
        //
        try {
            $restorans = Restoran::where("moderation", true)
                ->get();

            $restorans = $restorans->shuffle();

            $menu_categories = MenuCategory::all()->shuffle();

            View::share('restorans', $restorans);
            View::share('menu_categories', $menu_categories);
        } catch (\Exception $e) {

        }

    }
}
