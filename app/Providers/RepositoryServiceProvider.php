<?php

namespace App\Providers;

use App\Data\Repositories\User\UserRepository;
use App\Data\Repositories\User\EloquentRepository as UserEloquent;
use App\Data\Repositories\Product\ProductRepository;
use App\Data\Repositories\Product\EloquentRepository as ProductEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( UserRepository::class, UserEloquent::class );
        $this->app->bind( ProductRepository::class, ProductEloquent::class );
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
