<?php

namespace Tests\Feature\Auth;

class LogoutTest extends AuthBaseTest
{
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
        $this->user->createToken('authToken');
        $response = $this->post(route('users.logout'));

        $response->assertStatus(200);
        $this->assertEmpty($this->user->tokens);

    }
}
