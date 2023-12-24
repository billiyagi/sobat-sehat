<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationEventSubscribers extends Model
{
    use HasFactory;
    protected $table = 'registration_event_subscribers';
    protected $fillable = ['id', 'user_id', 'event_id', 'arrival_at', 'created_at', 'updated_at'];

    public function subscribers()
    {
        return $this->belongsTo(UserSubscribers::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
