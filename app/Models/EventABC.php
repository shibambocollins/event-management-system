<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventABC extends Model
{
    protected $table = 'events';
    
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'max_attendees',
        'organizer_id'
    ];
    
    protected $casts = [
        'event_date' => 'datetime',
    ];
    
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    
   // Added method to get registrations for the event
    public function registrations(): HasMany
    {
        return $this->hasMany(RegistrationABC::class, 'event_id');
    }
    
    public function getApprovedCountAttribute(): int
    {
        return $this->registrations()->where('status', 'approved')->count();
    }
    
    public function isFull(): bool
    {
        return $this->getApprovedCountAttribute() >= $this->max_attendees;
    }
}