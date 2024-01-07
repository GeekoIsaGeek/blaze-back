<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    public function test_user_can_sign_up(): void
    {
        $response = $this->postJson(route('users.register'), [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'birthdate' => '1990-01-01',
        ]);

        $this->isAuthenticated();
        $response->assertStatus(200);
    }

    public function test_user_should_not_be_registered_if_any_field_is_missing(): void
    {
        $response = $this->postJson(route('users.register'), [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'birthdate' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('birthdate');
    }

    public function test_user_should_not_be_registered_if_password_is_too_short(): void
    {
        $response = $this->postJson(route('users.register'), [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pass',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('password');

    }

    public function test_user_should_not_be_registered_if_email_is_invalid(): void
    {
        $response = $this->postJson(route('users.register'), [
            'username' => 'Test User',
            'email' => 'test@',
            'password' => 'password',
            'birthdate' => '1990-01-01',
        ]);
        $response->assertJsonValidationErrorFor('email');

    }

    public function test_user_should_not_be_registered_if_username_does_not_contain_at_least_six_chars(): void
    {
        $response = $this->postJson(route('users.register'), [
            'username' => 'asd',
            'email' => 'test@example.com',
            'password' => 'password',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertJsonValidationErrorFor('username');
    }

    public function test_user_should_not_be_registered_if_email_is_not_unique(): void
    {
        $this->user = User::factory()->create();
        $response = $this->postJson(route('users.register'), [
            'username' => 'Test User',
            'email' => $this->user->email,
            'password' => 'password',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertJsonValidationErrorFor('email');
    }

    public function test_user_should_not_be_registered_if_username_is_not_unique(): void
    {
        $this->user = User::factory()->create();
        $response = $this->postJson(route('users.register'), [
            'username' => $this->user->username,
            'email' => 'test@example.com',
            'password' => 'password',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertJsonValidationErrorFor('username');

    }
}
