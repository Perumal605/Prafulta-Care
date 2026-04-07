<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounsellorAvailability extends Model
{
    protected $fillable = [
        'counsellor_id',
        'available_date',
        'start_time',
        'end_time',
        'is_available',
        'source',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'available_date' => 'date',
            'is_available' => 'bool',
        ];
    }

    public function counsellor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counsellor_id');
    }
}
