<?php

namespace App\Services\Startup\Infrastructure\Contracts;

use App\Services\Startup\Infrastructure\DataTransferObjects\MessageData;

interface GetStartupMessageInterface
{
    public function getStartupMessage(): MessageData;
}
