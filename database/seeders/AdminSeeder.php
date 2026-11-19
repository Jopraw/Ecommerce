<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent: aman dijalankan berulang
        User::firstOrCreate(
            ['email' => 'admin@astrostep.com'],
            ['name' => 'Admin AstroStep', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'budi@email.com'],
            ['name' => 'Budi Santoso', 'password' => Hash::make('password'), 'role' => 'customer']
        );
    }
}
