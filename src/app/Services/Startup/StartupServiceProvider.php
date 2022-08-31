<?php

namespace App\Services\Startup;

use Illuminate\Support\ServiceProvider;
use App\Services\Startup\Domain\Subservices\StartupSubservice;
use App\Services\Startup\Infrastructure\Contracts\GetStartupMessageInterface;

final class StartupServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string[]>
     */
    protected array $subservices = [
        StartupSubservice::class => [
            GetStartupMessageInterface::class
        ]
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerSubservices($this->subservices);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * @param array $subservices
     * @return void
     */
    public function registerSubservices(array $subservices): void
    {
        foreach ($subservices as $subservice => $interfaces) {
            foreach ($interfaces as $interface) {
                $this->app->bind($interface, $subservice);
            }
        }
    }
}
