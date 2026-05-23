<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationABC extends Model
{
    protected $table = 'registrations';
    
    protected $fillable = ['event_id', 'user_id', 'status'];
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(EventABC::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}