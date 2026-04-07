<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingProgramme extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'location',
        'start_date',
        'end_date',
        'modules',
        'registration_fee',
        'balance_fee',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'modules' => 'array',
            'registration_fee' => 'decimal:2',
            'balance_fee' => 'decimal:2',
            'is_active' => 'bool',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class);
    }
}
