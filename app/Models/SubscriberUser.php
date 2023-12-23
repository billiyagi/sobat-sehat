<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberUser extends Model
{
    use HasFactory;
    protected $table = 'subscriberUser';
    protected $fillable = [
        'name', 'email', 'role_id', 'created_at', 'updated_at'
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
