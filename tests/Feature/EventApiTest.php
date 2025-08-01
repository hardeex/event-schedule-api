<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Test Event',
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
            'max_participants' => 10,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'name', 'start_datetime']]);
    }

    public function test_prevents_overlapping_registration()
    {
        $user = User::factory()->create();
        $event1 = Event::factory()->create([
            'start_datetime' => '2025-08-01 10:00:00',
            'end_datetime' => '2025-08-01 12:00:00',
        ]);
        $event2 = Event::factory()->create([
            'start_datetime' => '2025-08-01 11:00:00',
            'end_datetime' => '2025-08-01 13:00:00',
        ]);

        $this->postJson('/api/events/register', [
            'user_id' => $user->id,
            'event_id' => $event1->id,
        ]);

        $response = $this->postJson('/api/events/register', [
            'user_id' => $user->id,
            'event_id' => $event2->id,
        ]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Schedule conflict detected']);
    }
}