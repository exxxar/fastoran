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
            $header_kitchen_list = Kitchen::where("is_active", 1)->get();

            $restorans = Restoran::where("moderation", true)->get();

            View::share('header_kitchen_list', $header_kitchen_list);
            View::share('restorans', $restorans);
        } catch (\Exception $e) {

        }

    }
}
