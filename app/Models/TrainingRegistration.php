<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingRegistration extends Model
{
    protected $fillable = [
        'training_programme_id',
        'user_id',
        'participant_name',
        'email',
        'phone',
        'address',
        'form_data',
        'status',
        'payment_status',
        'registration_paid_amount',
        'balance_paid_amount',
    ];

    protected function casts(): array
    {
        return [
            'form_data' => 'array',
            'registration_paid_amount' => 'decimal:2',
            'balance_paid_amount' => 'decimal:2',
        ];
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(TrainingProgramme::class, 'training_programme_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
