<?php

namespace App\Services\Startup\Infrastructure\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

final class MessageData extends DataTransferObject
{
    public string $message;
}
