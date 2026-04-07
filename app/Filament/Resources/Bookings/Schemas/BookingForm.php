<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_reference')
                    ->required(),
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),
                Select::make('counsellor_id')
                    ->relationship('counsellor', 'name')
                    ->required(),
                Select::make('service_type')
                    ->options([
            'regular_counselling' => 'Regular counselling',
            'occupational_therapy' => 'Occupational therapy',
            'remedial_therapy' => 'Remedial therapy',
        ])
                    ->required(),
                Select::make('session_mode')
                    ->options(['video' => 'Video', 'call' => 'Call', 'in_person' => 'In person']),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                TextInput::make('duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(60),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rescheduled' => 'Rescheduled',
        ])
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'partial' => 'Partial', 'refunded' => 'Refunded'])
                    ->default('pending')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_offline_booking')
                    ->required(),
                TextInput::make('created_by')
                    ->numeric(),
            ]);
    }
}
