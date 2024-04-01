<?php

namespace App\Providers;

use App\Http\Repositories\ProductRepositorie;
use App\Http\Repositories\ProductRepositorieInterface;
use Illuminate\Support\ServiceProvider;

class ProductRepositorieServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepositorieInterface::class, ProductRepositorie::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
