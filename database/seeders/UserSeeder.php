<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'password',
        ]);

    }
}
