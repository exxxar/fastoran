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

        try {
            $kitchens = (Kitchen::where("is_active", 1)
                ->get())->filter(function ($kitchen) {
                return $kitchen->rest_count > 0;
            });

            $restorans = Restoran::where("moderation", true)->get();

            View::share('kitchens', $kitchens);
            View::share('restorans', $restorans);
        } catch (\Exception $e) {

        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //


    }
}
