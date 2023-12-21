<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'password',
        ]);
    }
}
