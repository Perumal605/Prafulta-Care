<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounsellorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'photo_path',
        'bio',
        'specializations',
        'session_modes',
        'session_duration_minutes',
        'session_price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'specializations' => 'array',
            'session_modes' => 'array',
            'session_price' => 'decimal:2',
            'is_active' => 'bool',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
