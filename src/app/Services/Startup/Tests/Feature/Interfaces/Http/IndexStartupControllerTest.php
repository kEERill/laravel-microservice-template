<?php

namespace App\Services\Startup\Tests\Feature\Interfaces\Http;

use Tests\TestCase;

final class IndexStartupControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_get_message(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertJsonPath('data.message', 'Hello world');
    }
}
