<?php

namespace App\Filament\Resources\TrainingRegistrations;

use App\Filament\Resources\TrainingRegistrations\Pages\CreateTrainingRegistration;
use App\Filament\Resources\TrainingRegistrations\Pages\EditTrainingRegistration;
use App\Filament\Resources\TrainingRegistrations\Pages\ListTrainingRegistrations;
use App\Filament\Resources\TrainingRegistrations\Schemas\TrainingRegistrationForm;
use App\Filament\Resources\TrainingRegistrations\Tables\TrainingRegistrationsTable;
use App\Models\TrainingRegistration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingRegistrationResource extends Resource
{
    protected static ?string $model = TrainingRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TrainingRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingRegistrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingRegistrations::route('/'),
            'create' => CreateTrainingRegistration::route('/create'),
            'edit' => EditTrainingRegistration::route('/{record}/edit'),
        ];
    }
}
