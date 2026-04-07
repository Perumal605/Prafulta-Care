<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = [
        'booking_id',
        'counsellor_id',
        'notes',
    ];
}
