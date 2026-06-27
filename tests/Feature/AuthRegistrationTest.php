<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    public function test_register_returns_proper_422_validation_errors()
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['name', 'email', 'phone', 'password']);
    }
}
