<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference',
        'client_id',
        'counsellor_id',
        'service_type',
        'session_mode',
        'scheduled_at',
        'duration_minutes',
        'status',
        'payment_status',
        'amount',
        'discount_amount',
        'is_offline_booking',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'is_offline_booking' => 'bool',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function counsellor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counsellor_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
