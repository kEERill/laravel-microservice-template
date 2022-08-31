<?php

namespace App\Services\Startup\Interfaces\Http\Resources;

use Illuminate\Http\Request;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Property;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Startup\Infrastructure\DataTransferObjects\MessageData;

#[Schema(
    title: 'Message Startup Resource',
    description: 'Структура приветственного сообщения'
)]
final class MessageStartupResource extends JsonResource
{
    /**
     * @var MessageData
     */
    public $resource;

    #[Property(description: 'Сообщение')]
    public string $message = 'Hello world';

    /**
     * @param MessageData $resource
     * @return void
     */
    public function __construct(MessageData $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param Request $request
     * @return string[]
     */
    public function toArray($request): array
    {
        return [
            'message' => $this->resource->message
        ];
    }
}
