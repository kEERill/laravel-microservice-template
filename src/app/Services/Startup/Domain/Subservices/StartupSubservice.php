<?php

namespace App\Services\Startup\Domain\Subservices;

use App\Services\Startup\Infrastructure\Contracts\GetStartupMessageInterface;
use App\Services\Startup\Infrastructure\DataTransferObjects\MessageData;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class StartupSubservice implements GetStartupMessageInterface
{
    /**
     * @return MessageData
     * @throws UnknownProperties
     */
    public function getStartupMessage(): MessageData
    {
        return new MessageData(['message' => 'Hello world']);
    }
}
