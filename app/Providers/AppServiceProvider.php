<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if(!app()->runningInConsole()){
        $setting = Setting::firstOr(function () {
            return Setting::create([
                 'name' => 'site_name',
                 'description' => 'Laravel'
             ]);
          });
          view()->share('setting', $setting);
        }
    }
}
