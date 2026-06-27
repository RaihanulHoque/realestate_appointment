<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contacts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactAppointmentCrudTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user)
    {
        $token = auth('api')->login($user);

        return ['Authorization' => "Bearer {$token}"];
    }

    public function test_user_can_create_read_update_delete_their_own_contact()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->authHeaders($user))->postJson('/api/auth/contacts', [
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '12345',
            'address' => 'AB1 2CD',
        ]);

        $response->assertStatus(200)->assertJsonPath('success', true);
        $contactId = $response->json('contact.id');
        $this->assertNotNull($contactId);

        $this->withHeaders($this->authHeaders($user))
            ->getJson("/api/auth/contact/{$contactId}")
            ->assertStatus(200)
            ->assertJsonPath('data.email', 'jane@example.com');

        $this->withHeaders($this->authHeaders($user))
            ->putJson("/api/auth/contact/{$contactId}", ['name' => 'Janet'])
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertEquals('Janet', Contacts::find($contactId)->name);

        $this->withHeaders($this->authHeaders($user))
            ->deleteJson("/api/auth/contact/{$contactId}")
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertNull(Contacts::find($contactId));
    }

    public function test_contact_store_rejects_invalid_email()
    {
        $user = User::factory()->create();

        $this->withHeaders($this->authHeaders($user))->postJson('/api/auth/contacts', [
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'not-an-email',
            'phone' => '12345',
            'address' => 'AB1 2CD',
        ])->assertStatus(422);
    }

    public function test_user_cannot_create_appointment_for_another_users_contact()
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $contact = Contacts::create([
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane2@example.com',
            'phone' => '999999',
            'address' => 'AB1 2CD',
            'created_by' => $owner->id,
        ]);

        $this->withHeaders($this->authHeaders($intruder))->postJson('/api/auth/appointments', [
            'contact_id' => $contact->id,
            'appointment_date' => '2026-07-01',
            'appointment_address' => 'AB1 2CD',
            'appointment_start_time' => '10:00:00',
        ])->assertStatus(422);
    }

    public function test_user_can_create_appointment_for_own_contact()
    {
        $user = User::factory()->create();

        $contact = Contacts::create([
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane3@example.com',
            'phone' => '888888',
            'address' => 'AB1 2CD',
            'created_by' => $user->id,
        ]);

        $this->withHeaders($this->authHeaders($user))->postJson('/api/auth/appointments', [
            'contact_id' => $contact->id,
            'appointment_date' => '2026-07-01',
            'appointment_address' => 'AB1 2CD',
            'appointment_start_time' => '10:00:00',
        ])->assertStatus(200)->assertJsonPath('success', true);
    }

    public function test_updating_appointment_start_time_recomputes_derived_schedule()
    {
        $user = User::factory()->create();

        $contact = Contacts::create([
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'jane4@example.com',
            'phone' => '777777',
            'address' => 'AB1 2CD',
            'created_by' => $user->id,
        ]);

        $createResponse = $this->withHeaders($this->authHeaders($user))->postJson('/api/auth/appointments', [
            'contact_id' => $contact->id,
            'appointment_date' => '2026-07-01',
            'appointment_address' => 'AB1 2CD',
            'appointment_start_time' => '10:00:00',
        ]);
        $appointmentId = $createResponse->json('appointment.id');

        $this->withHeaders($this->authHeaders($user))
            ->putJson("/api/auth/appointment/{$appointmentId}", ['appointment_start_time' => '14:00:00'])
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $appointment = \App\Models\Appointments::find($appointmentId);
        $this->assertEquals('14:00:00', $appointment->appointment_start_time);
        $this->assertEquals('13:30:00', $appointment->departure_time_to_site_office);
        $this->assertEquals('15:00:00', $appointment->appointment_end_time);
        $this->assertEquals('15:40:00', $appointment->arrival_time_to_agent_office);
    }
}
