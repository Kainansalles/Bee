<?php

namespace App\Providers;

use App\Repositories\Consumer\ConsumerRepositoryEloquent;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Repositories\Feed\FeedRepositoryEloquent;
use App\Repositories\Feed\Contracts\FeedRepositoryContract;
use App\Services\Feed\FeedService;
use App\Services\Feed\Contracts\FeedServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FeedServiceContract::class,
            FeedService::class
        );
        $this->app->bind(
            FeedRepositoryContract::class,
            FeedRepositoryEloquent::class
        );
        $this->app->bind(
            ConsumerRepositoryContract::class,
            ConsumerRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        return [
            FeedService::class,
            FeedRepositoryEloquent::class,
            ConsumerRepositoryEloquent::class,
        ];
    }
}
