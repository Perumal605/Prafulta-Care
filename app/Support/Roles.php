<?php

namespace App\Support;

class Roles
{
    public const ADMIN = 'admin';
    public const CLIENT = 'client';
    public const COUNSELLOR = 'counsellor';
    public const TRAINING_MANAGER = 'training_manager';

    public static function all(): array
    {
        return [
            self::ADMIN,
            self::CLIENT,
            self::COUNSELLOR,
            self::TRAINING_MANAGER,
        ];
    }
}
