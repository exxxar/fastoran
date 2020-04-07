<?php

namespace App\Providers;

use App\Parts\Models\Fastoran\Kitchen;
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
        //
        try {
            $kitchens = Kitchen::where("is_active", 1)->get();

            $restorans = Restoran::where("moderation", true)->get();

            View::share('kitchens', $kitchens);
            View::share('restorans', $restorans);
        } catch (\Exception $e) {

        }

    }
}
