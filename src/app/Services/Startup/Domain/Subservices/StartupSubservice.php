<?php

namespace App\Services\Startup\Domain\Subservices;

use KEERill\ServiceStructure\Attributes\RegisterAction;
use App\Services\Startup\Infrastructure\Contracts\GetStartupMessageInterface;
use App\Services\Startup\Infrastructure\DataTransferObjects\MessageData;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class StartupSubservice
    implements GetStartupMessageInterface
{
    /**
     * @throws UnknownProperties
     */
    #[RegisterAction(GetStartupMessageInterface::class)]
    public function getStartupMessage(): MessageData
    {
        return new MessageData(['message' => 'Hello world']);
    }
}
