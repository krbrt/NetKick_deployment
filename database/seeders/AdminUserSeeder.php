<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@netkicks.com',
            'password'          => Hash::make('admin123'),
            'usertype'          => 'admin',
            'email_verified_at' => now(),
        ]);

    }
}