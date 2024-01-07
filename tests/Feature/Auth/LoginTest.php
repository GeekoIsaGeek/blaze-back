<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(["password" => bcrypt("password123")]);
    }

    public function test_user_can_login(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "password123"]));

        $response->assertStatus(200);
        $response->assertJsonStructure(["user"]);

    }

    public function test_user_cannot_login_with_wrong_credentials(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "123"]));

        $response->assertStatus(404);
        $response->assertJsonMissing(["user"]);
    }

    public function test_after_loggin_in_token_is_created_and_returned_to_client(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "password123"]));

        $response->assertStatus(200);
        $response->assertJsonStructure(["user","token"]);
    }
}
