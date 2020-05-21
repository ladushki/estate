<?php

namespace App\Providers;

use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(PropertyTypeRepositoryInterface::class, PropertyTypeRepository::class);
    }
}
