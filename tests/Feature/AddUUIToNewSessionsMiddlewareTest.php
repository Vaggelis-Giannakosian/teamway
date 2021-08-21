<?php

namespace Tests\Feature;

use Tests\TestCase;

class AddUUIToNewSessionsMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_middleware_assigns_session_uuid_to_new_users_if_they_dont_have()
    {
        $this->assertNull(session()->get('uuid'));

        $this->get('/');

        $sessionId = session()->get('uuid');

        $this->assertNotNull($sessionId);
        $this->assertTrue(\Str::isUuid($sessionId));

        $this->get('/');

        $this->assertEquals($sessionId,session()->get('uuid'));
    }

}
