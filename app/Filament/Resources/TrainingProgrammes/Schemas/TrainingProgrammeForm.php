<?php

namespace App\Filament\Resources\TrainingProgrammes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TrainingProgrammeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('location'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                TextInput::make('modules'),
                TextInput::make('registration_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('balance_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
