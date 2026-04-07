<?php

namespace App\Filament\Resources\CounsellorProfiles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CounsellorProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('photo_path'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                TextInput::make('specializations'),
                TextInput::make('session_modes'),
                TextInput::make('session_duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(60),
                TextInput::make('session_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
