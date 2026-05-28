<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EventABC;
use App\Models\RegistrationABC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Create organizer user
        $organizer = User::create([
            'name' => 'John Organizer',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);
        
        // Create attendee users
        $attendee1 = User::create([
            'name' => 'Sarah Attendee',
            'email' => 'attendee@example.com',
            'password' => Hash::make('password'),
            'role' => 'attendee',
        ]);
        
        $attendee2 = User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@example.com',
            'password' => Hash::make('password'),
            'role' => 'attendee',
        ]);
        
        // Create sample events
        $event1 = EventABC::create([
            'title' => 'Laravel Workshop 2026',
            'description' => 'Learn Laravel 12 from scratch. Perfect for beginners and intermediate developers.',
            'event_date' => now()->addDays(14),
            'location' => 'Online via Zoom',
            'max_attendees' => 30,
            'organizer_id' => $organizer->id,
        ]);
        
        $event2 = EventABC::create([
            'title' => 'Web Development Conference',
            'description' => 'Annual web development conference featuring expert speakers.',
            'event_date' => now()->addDays(30),
            'location' => 'Convention Center, New York',
            'max_attendees' => 100,
            'organizer_id' => $organizer->id,
        ]);
        
        $event3 = EventABC::create([
            'title' => 'Database Design Seminar',
            'description' => 'Learn best practices for database design and optimization.',
            'event_date' => now()->addDays(7),
            'location' => 'Tech Hub, San Francisco',
            'max_attendees' => 50,
            'organizer_id' => $admin->id,
        ]);
        
        // Create sample registrations
        RegistrationABC::create([
            'event_id' => $event1->id,
            'user_id' => $attendee1->id,
            'status' => 'approved',
        ]);
        
        RegistrationABC::create([
            'event_id' => $event1->id,
            'user_id' => $attendee2->id,
            'status' => 'pending',
        ]);
        
        RegistrationABC::create([
            'event_id' => $event2->id,
            'user_id' => $attendee1->id,
            'status' => 'pending',
        ]);
    }
}