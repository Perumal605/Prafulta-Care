<?php

namespace App\Models;

use App\Support\Roles;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function counsellorProfile(): HasOne
    {
        return $this->hasOne(CounsellorProfile::class);
    }

    public function counsellorAvailabilities(): HasMany
    {
        return $this->hasMany(CounsellorAvailability::class, 'counsellor_id');
    }

    public function clientBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function counsellorBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'counsellor_id');
    }

    public function counsellorAttendances(): HasMany
    {
        return $this->hasMany(CounsellorAttendance::class, 'counsellor_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === Roles::ADMIN;
    }

    public function isClient(): bool
    {
        return $this->role === Roles::CLIENT;
    }

    public function isCounsellor(): bool
    {
        return $this->role === Roles::COUNSELLOR;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, [Roles::ADMIN, Roles::TRAINING_MANAGER], true);
    }
}
