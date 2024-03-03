<?php

namespace App\Providers;

use App\Http\Repositories\UserRepositorie;
use App\Http\Repositories\UserRepositorieInterface;
use Illuminate\Support\ServiceProvider;

class RepositorieServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositorieInterface::class, UserRepositorie::class);
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
