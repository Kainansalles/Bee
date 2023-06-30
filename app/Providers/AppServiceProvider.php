<?php

namespace App\Providers;

use App\Repositories\Consumer\ConsumerRepository;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Services\Consumer\ConsumerService;
use App\Services\Consumer\Contracts\ConsumerServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ConsumerServiceContract::class,
            ConsumerService::class
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
            ConsumerService::class,
            ConsumerRepository::class
        ];
    }
}
