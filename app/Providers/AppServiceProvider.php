<?php

namespace App\Providers;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;


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
        // if(!app()->runningInConsole()){
        // $setting = Setting::firstOr(function () {
        //     return Setting::create([
        //          'name' => 'site_name',
        //          'description' => 'Laravel'
        //      ]);
        //   });
        //   view()->share('setting', $setting);
        // }
    }
}
