<?php

namespace App\Attributes;


use OpenApi\Attributes\Items;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\JsonContent;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class JsonValidationErrorsResponse extends Response
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            response: 419,
            description: 'Ошибки в процессе выполнения запроса',
            content: new JsonContent(properties: [
                new Property(
                    property: 'message',
                    type: 'string',
                    example: 'The given data was invalid.'
                ),

                new Property(
                    property: 'errors',
                    properties: [
                        new Property(
                            property: 'field',
                            type: 'array',
                            items: new Items(type: 'string', example: 'Описание ошибки'))
                    ],
                    type: 'object'
                )
            ])
        );
    }
}
