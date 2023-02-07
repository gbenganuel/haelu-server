<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\MNARepository;
use App\Repositories\Interfaces\MNAInterface;

class MNAServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MNAInterface::class,
            MNARepository::class
        );
    }
}
