<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Requests\Content\ContentRequestInterface;
use App\Http\Requests\Content\ContentStoreRequest;
use App\Http\Requests\Content\ContentUpdateRequest;
use App\Http\Requests\Fiuselist\FiuselistAddContentRequest;
use App\Http\Requests\Fiuselist\FiuselistRequestInterface;
use App\Http\Requests\RequestInterface;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContentRequestInterface::class, ContentUpdateRequest::class);
        $this->app->bind(ContentRequestInterface::class, ContentStoreRequest::class);
        $this->app->bind(FiuselistRequestInterface::class, FiuselistAddContentRequest::class);
        $this->app->bind(RequestInterface::class, ContentUpdateRequest::class);
        $this->app->bind(RequestInterface::class, ContentStoreRequest::class);
        $this->app->bind(RequestInterface::class, FiuselistAddContentRequest::class);
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
