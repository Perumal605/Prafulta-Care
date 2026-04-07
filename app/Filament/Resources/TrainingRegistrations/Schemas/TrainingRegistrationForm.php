<?php

namespace App\Filament\Resources\TrainingRegistrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TrainingRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('training_programme_id')
                    ->required()
                    ->numeric(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('participant_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('form_data'),
                Select::make('status')
                    ->options([
            'submitted' => 'Submitted',
            'approved' => 'Approved',
            'cancelled' => 'Cancelled',
            'confirmed' => 'Confirmed',
        ])
                    ->default('submitted')
                    ->required(),
                Select::make('payment_status')
                    ->options([
            'pending' => 'Pending',
            'registration_paid' => 'Registration paid',
            'fully_paid' => 'Fully paid',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('registration_paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('balance_paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
