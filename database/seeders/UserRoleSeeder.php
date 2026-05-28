<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Organizer User
        User::create([
            'name' => 'Organizer User',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);
        
        // Regular Attendee
        User::create([
            'name' => 'Attendee User',
            'email' => 'attendee@example.com',
            'password' => Hash::make('password'),
            'role' => 'attendee',
        ]);
    }
}