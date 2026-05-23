<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected \ = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected \ = [
        'password',
        'remember_token',
    ];

    protected \ = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return \->role === 'admin';
    }

    public function isOrganizer(): bool
    {
        return \->role === 'organizer';
    }

    public function isAttendee(): bool
    {
        return \->role === 'attendee';
    }

    public function organizedEvents()
    {
        return \->hasMany(EventABC::class, 'organizer_id');
    }

    public function registrations()
    {
        return \->hasMany(RegistrationABC::class);
    }
}
