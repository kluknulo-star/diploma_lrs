<?php

namespace App\Providers;

use App\Statements\repository\impl\StatementEloquentRepositoryImpl;
use App\Statements\repository\impl\StatementRepositoryImpl;
use App\Statements\repository\StatementRepository;
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
        $this->app->bind(
            StatementRepository::class,
            StatementRepositoryImpl::class,
//            StatementEloquentRepositoryImpl::class
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
