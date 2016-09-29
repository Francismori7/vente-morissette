<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL, 'fr_CA', 'fr_CA.UTF-8');
        Carbon::setLocale('fr');

        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('fr_CA');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
