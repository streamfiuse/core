<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\Repositories\Fiuselist\FiuselistRepository;
use App\Infrastructure\Repositories\Fiuselist\FiuselistRepositoryInterface;

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
        $this->app->bind(FiuselistRepositoryInterface::class, FiuselistRepository::class);
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
