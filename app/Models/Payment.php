<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'training_registration_id',
        'payment_purpose',
        'method',
        'status',
        'amount',
        'transaction_reference',
        'receipt_number',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function trainingRegistration(): BelongsTo
    {
        return $this->belongsTo(TrainingRegistration::class);
    }
}
