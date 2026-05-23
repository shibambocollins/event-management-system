<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationABC extends Model
{
    protected \ = 'registrations';
    
    protected \ = ['event_id', 'user_id', 'status'];
    
    public function event(): BelongsTo
    {
        return \->belongsTo(EventABC::class);
    }
    
    public function user(): BelongsTo
    {
        return \->belongsTo(User::class);
    }
}
