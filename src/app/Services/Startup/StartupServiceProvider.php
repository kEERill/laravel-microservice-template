<?php

namespace App\Services\Startup;

use App\Services\Startup\Domain\Subservices\StartupSubservice;
use App\Services\Startup\Infrastructure\Contracts\GetStartupMessageInterface;
use KEERill\ServiceStructure\Services\AbstractServiceProvider;
use KEERill\ServiceStructure\Services\ServiceConfigurator;

final class StartupServiceProvider extends AbstractServiceProvider
{
    /**
     * @param ServiceConfigurator $serviceConfigurator
     * @return void
     */
    protected function configureService(ServiceConfigurator $serviceConfigurator): void
    {
        $serviceConfigurator->usingRoutes();
    }
}
