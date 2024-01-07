<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['password' => bcrypt("password123")]);
        $user->createToken('authToken');

        $this->user = $user;
    }

    public function test_user_can_logout(): void
    {
        $this->actingAs($this->user);
        $response = $this->post(route('users.logout'));

        $response->assertStatus(200);
        $this->assertFalse(auth()->hasUser());
    }

    public function test_user_tokens_are_revoked_after_logging_out(): void
    {
        $this->actingAs($this->user);
        $response = $this->post(route('users.logout'));

        $response->assertStatus(200);
        $this->assertEmpty($this->user->tokens);

    }
}
