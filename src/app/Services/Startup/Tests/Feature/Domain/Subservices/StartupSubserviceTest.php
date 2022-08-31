<?php

namespace App\Services\Startup\Tests\Feature\Domain\Subservices;

use App\Services\Startup\Domain\Subservices\StartupSubservice;
use App\Services\Startup\Infrastructure\DataTransferObjects\MessageData;
use Tests\TestCase;

final class StartupSubserviceTest extends TestCase
{
    public function test_get_message(): void
    {
        /** @var MessageData $messageData */
        $messageData = $this->app->make(StartupSubservice::class)
            ->getStartupMessage();

        $this->assertEquals('Hello world', $messageData->message);
    }
}
