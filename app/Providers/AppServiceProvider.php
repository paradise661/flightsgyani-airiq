<?php

namespace App\Providers;

use Illuminate\Support\Collection;
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
        Collection::macro('transpose', function () {
            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());
            return new static($items);
        });
        $this->app->register(ViewServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);


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
