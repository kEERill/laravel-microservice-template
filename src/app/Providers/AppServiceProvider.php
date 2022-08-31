<?php

namespace App\Providers;

use App\Services\Startup\StartupServiceProvider;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * @var class-string[]
     */
    protected array $services = [
        StartupServiceProvider::class
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerServices($this->services);
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot(): void
    {}

    /**
     * @param array $services
     * @return void
     */
    private function registerServices(array $services): void
    {
        foreach ($services as $service) {
            $this->app->register($service);
        }
    }
}
