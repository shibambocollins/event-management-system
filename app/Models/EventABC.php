<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventABC extends Model
{
    protected \ = 'events';
    
    protected \ = [
        'title', 'description', 'event_date', 
        'location', 'max_attendees', 'organizer_id'
    ];
    
    protected \ = [
        'event_date' => 'datetime',
    ];
    
    public function organizer(): BelongsTo
    {
        return \->belongsTo(User::class, 'organizer_id');
    }
    
    public function registrations(): HasMany
    {
        return \->hasMany(RegistrationABC::class, 'event_id');
    }
    
    public function getApprovedCountAttribute(): int
    {
        return \->registrations()->where('status', 'approved')->count();
    }
    
    public function isFull(): bool
    {
        return \->approved_count >= \->max_attendees;
    }
}
