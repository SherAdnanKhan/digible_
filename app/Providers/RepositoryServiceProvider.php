<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
       $this->app->bind(
           'App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface',
           'App\Http\Repositories\Users\PaymentRepository'
       );
    }
}
