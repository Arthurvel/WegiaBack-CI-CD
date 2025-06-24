<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Hashing\Sha256Hasher;

class Sha256HashServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Sha256Hasher::class, function () {
            return new Sha256Hasher();
        });


        $this->app->booting(function () {
            Hash::extend('sha256', function () {
                return app(Sha256Hasher::class);
            });
        });
    }
}