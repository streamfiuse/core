<?php

namespace App\Providers;

use App\Repositories\EloquentBaseRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\Fiuselist\FiuselistRepository;
use App\Repositories\Fiuselist\FiuselistRepositoryInterface;
use App\Repositories\QueryBaseRepository;
use App\Repositories\QueryRepositoryInterface;
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
        //$this->app->bind(EloquentRepositoryInterface::class, EloquentBaseRepository::class);
        //$this->app->bind(QueryRepositoryInterface::class, QueryBaseRepository::class);
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
