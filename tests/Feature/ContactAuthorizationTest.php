<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactAuthorizationTest extends TestCase
{
    public function test_unauthenticated_request_is_rejected_not_crashed()
    {
        $response = $this->getJson('/api/auth/contacts');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_appointment_request_is_rejected_not_crashed()
    {
        $response = $this->getJson('/api/auth/appointments');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_request_without_json_accept_header_still_gets_401_not_a_crash()
    {
        $response = $this->get('/api/auth/contacts');

        $response->assertStatus(401);
    }
}
