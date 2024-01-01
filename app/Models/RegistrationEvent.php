<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationEvent extends Model
{
    use HasFactory;
    protected $table = 'register_event';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
