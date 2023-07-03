<?php

namespace App\Providers;

use App\Repositories\Consumer\ConsumerRepository;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Repositories\Feed\FeedRepository;
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
            FeedRepository::class
        );
        $this->app->bind(
            ConsumerRepositoryContract::class,
            ConsumerRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        return [
            FeedService::class,
            FeedRepository::class,
            ConsumerRepository::class,
        ];
    }
}
