<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'name', 'created_at', 'updated_at'];

    public function event()
    {
        return $this->hasMany(RegistrationEventUser::class, 'user_id');
    }
}
