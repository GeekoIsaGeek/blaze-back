<?php

namespace Tests\Feature\Auth;

class LoginTest extends AuthBaseTest
{
    public function test_user_can_login(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "password123"]));

        $response->assertStatus(200);
        $response->assertJsonStructure(["user"]);

    }

    public function test_user_can_not_login_with_wrong_credentials(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "123"]));

        $response->assertStatus(404);
        $response->assertJsonMissing(["user"]);
    }

    public function test_after_logging_in_token_is_created_and_returned_to_client(): void
    {
        $response = $this->post(route('users.login', ["email" => $this->user->email, "password" => "password123"]));

        $response->assertStatus(200);
        $response->assertJsonStructure(["user","token"]);
    }
}
