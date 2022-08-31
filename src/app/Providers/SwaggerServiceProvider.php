<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

final class SwaggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (!$this->app->environment('production')) {
            $this->app->register(L5SwaggerServiceProvider::class);
        }
    }
}
