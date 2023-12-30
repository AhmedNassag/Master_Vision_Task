<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*** Start Dashboard ***/
        //Category
        $this->app->bind(
            'App\Repositories\Dashboard\Category\CategoryInterface',
            'App\Repositories\Dashboard\Category\CategoryRepository',
        );

        //Product
        $this->app->bind(
            'App\Repositories\Dashboard\Product\ProductInterface',
            'App\Repositories\Dashboard\Product\ProductRepository',
        );

        //Shop
        $this->app->bind(
            'App\Repositories\Dashboard\Shop\ShopInterface',
            'App\Repositories\Dashboard\Shop\ShopRepository',
        );

        //ShopProduct
        $this->app->bind(
            'App\Repositories\Dashboard\ShopProduct\ShopProductInterface',
            'App\Repositories\Dashboard\ShopProduct\ShopProductRepository',
        );
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
