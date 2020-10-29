<?php

namespace App\Providers;

use App\Repositories\AdministratorContract;
use App\Repositories\AdministratorRepository;
use App\Repositories\ClientContract;
use App\Repositories\ClientRepository;
use App\Repositories\PermissionContract;
use App\Repositories\PermissionRepository;
use App\Repositories\UserContract;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(AdministratorContract::class, AdministratorRepository::class);
        $this->app->bind(ClientContract::class, ClientRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(PermissionContract::class, PermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
