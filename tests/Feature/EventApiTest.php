<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $manager;
    protected $token;
    protected $managerToken;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Fake mail to prevent actual email sending during tests
        Mail::fake();

        // Create a regular user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('Password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create a manager
        $this->manager = User::create([
            'name' => 'Test Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('Password123'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // Generate JWT tokens
        $this->token = JWTAuth::fromUser($this->user);
        $this->managerToken = JWTAuth::fromUser($this->manager);
    }

    /**
     * Test user registration.
     */
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'role' => 'user',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Registration successful - Welcome to Event Scheduler. Please verify your email to have access for creating and managing events.',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ]);
    }

    /**
     * Test user registration with invalid data.
     */
    public function test_user_registration_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'status' => 'error',
                     'message' => 'Validation failed.',
                     'errors' => ['name', 'email', 'password'],
                 ]);
    }

    /**
     * Test user login.
     */
    public function test_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@test.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token',
                     'message' => 'Login successful',
                     'user' => ['name', 'email', 'role'],
                 ]);
    }

    /**
     * Test login with unverified email.
     */
    public function test_login_fails_with_unverified_email()
    {
        $unverifiedUser = User::create([
            'name' => 'Unverified User',
            'email' => 'unverified@test.com',
            'password' => bcrypt('Password123'),
            'role' => 'user',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'unverified@test.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(403)
                 ->assertJson(['error' => 'Please verify your email first']);
    }

    /**
     * Test email verification.
     */
    public function test_email_verification()
    {
        $user = User::create([
            'name' => 'Verify User',
            'email' => 'verify@test.com',
            'password' => bcrypt('Password123'),
            'role' => 'user',
            'email_verification_token' => Str::random(60),
        ]);

        $response = $this->getJson('/api/verify/email?token=' . $user->email_verification_token);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Email verified successfully']);

        $this->assertDatabaseHas('users', [
            'email' => 'verify@test.com',
            'email_verified_at' => now(),
            'email_verification_token' => null,
        ]);
    }

    /**
     * Test resending verification email.
     */
    public function test_resend_verification_email()
    {
        $user = User::create([
            'name' => 'Resend User',
            'email' => 'resend@test.com',
            'password' => bcrypt('Password123'),
            'role' => 'user',
            'email_verification_token' => Str::random(60),
        ]);

        $response = $this->postJson('/api/email/resend', ['email' => 'resend@test.com']);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Verification email resent successfully.']);

        Mail::assertSent(\App\Mail\VerifyEmail::class);
    }

    /**
     * Test password reset request.
     */
    public function test_password_reset_request()
    {
        $response = $this->postJson('/api/password/reset-request', [
            'email' => 'user@test.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'If this email is registered, a reset link has been sent.']);

        $this->assertDatabaseHas('users', [
            'email' => 'user@test.com',
            'password_reset_token' => fn($value) => !is_null($value),
        ]);

        Mail::assertSent(\App\Mail\PasswordResetEmail::class);
    }

    /**
     * Test password reset.
     */
    public function test_password_reset()
    {
        $user = User::create([
            'name' => 'Reset User',
            'email' => 'reset@test.com',
            'password' => bcrypt('OldPassword123'),
            'role' => 'user',
            'password_reset_token' => Str::random(60),
            'password_reset_token_created_at' => now(),
        ]);

        $response = $this->postJson('/api/password/reset', [
            'token' => $user->password_reset_token,
            'password' => 'NewPassword123',
            'password_confirmation' => 'NewPassword123',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Password reset successfully']);

        $this->assertDatabaseHas('users', [
            'email' => 'reset@test.com',
            'password_reset_token' => null,
        ]);
    }

    /**
     * Test password change.
     */
    public function test_password_change()
    {
        $response = $this->postJson('/api/password/change', [
            'current_password' => 'Password123',
            'new_password' => 'NewPassword123',
            'new_password_confirmation' => 'NewPassword123',
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Password changed successfully']);
    }

    /**
     * Test get authenticated user.
     */
    public function test_get_authenticated_user()
    {
        $response = $this->getJson('/api/me', ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'user' => [
                         'email' => 'user@test.com',
                         'role' => 'user',
                     ],
                 ]);
    }

    /**
     * Test event creation (manager only).
     */
    public function test_manager_can_create_event()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Tech Meetup',
            'start_datetime' => now()->addDay()->toIso8601String(),
            'end_datetime' => now()->addDay()->addHours(2)->toIso8601String(),
            'max_participants' => 50,
        ], ['Authorization' => 'Bearer ' . $this->managerToken]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Event created successfully.',
                 ]);

        $this->assertDatabaseHas('events', [
            'name' => 'Tech Meetup',
            'max_participants' => 50,
        ]);
    }

    /**
     * Test event creation fails for non-manager.
     */
    public function test_non_manager_cannot_create_event()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Tech Meetup',
            'start_datetime' => now()->addDay()->toIso8601String(),
            'end_datetime' => now()->addDay()->addHours(2)->toIso8601String(),
            'max_participants' => 50,
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(403);
    }

    /**
     * Test listing events.
     */
    public function test_list_events()
    {
        Event::create([
            'name' => 'Test Event',
            'slug' => 'test-event',
            'start_datetime' => now()->addDay(),
            'end_datetime' => now()->addDay()->addHours(2),
            'max_participants' => 50,
        ]);

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'slug', 'start_datetime', 'end_datetime', 'max_participants'],
                     ],
                 ]);
    }

    /**
     * Test event registration.
     */
    public function test_user_can_register_for_event()
    {
        $event = Event::create([
            'name' => 'Test Event',
            'slug' => 'test-event',
            'start_datetime' => now()->addDay(),
            'end_datetime' => now()->addDay()->addHours(2),
            'max_participants' => 50,
        ]);

        $response = $this->postJson('/api/events/register', [
            'user_id' => $this->user->id,
            'event_id' => $event->id,
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id', 'name', 'start_datetime', 'end_datetime', 'max_participants', 'current_participants',
                 ]);

        $this->assertDatabaseHas('event_user', [
            'user_id' => $this->user->id,
            'event_id' => $event->id,
        ]);
    }

    /**
     * Test event cancellation (manager only).
     */
    public function test_manager_can_cancel_event()
    {
        $event = Event::create([
            'name' => 'Test Event',
            'slug' => 'test-event',
            'start_datetime' => now()->addDay(),
            'end_datetime' => now()->addDay()->addHours(2),
            'max_participants' => 50,
        ]);

        $response = $this->deleteJson('/api/events/delete/' . $event->id, [], ['Authorization' => 'Bearer ' . $this->managerToken]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Event cancelled successfully']);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    /**
     * Test event registration fails when event is full.
     */
    public function test_event_registration_fails_when_full()
    {
        $event = Event::create([
            'name' => 'Full Event',
            'slug' => 'full-event',
            'start_datetime' => now()->addDay(),
            'end_datetime' => now()->addDay()->addHours(2),
            'max_participants' => 1,
        ]);

        $event->participants()->attach($this->manager->id);

        $response = $this->postJson('/api/events/register', [
            'user_id' => $this->user->id,
            'event_id' => $event->id,
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Event is full']);
    }
}