<?php

namespace App\Filament\Resources\TrainingProgrammes;

use App\Filament\Resources\TrainingProgrammes\Pages\CreateTrainingProgramme;
use App\Filament\Resources\TrainingProgrammes\Pages\EditTrainingProgramme;
use App\Filament\Resources\TrainingProgrammes\Pages\ListTrainingProgrammes;
use App\Filament\Resources\TrainingProgrammes\Schemas\TrainingProgrammeForm;
use App\Filament\Resources\TrainingProgrammes\Tables\TrainingProgrammesTable;
use App\Models\TrainingProgramme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingProgrammeResource extends Resource
{
    protected static ?string $model = TrainingProgramme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TrainingProgrammeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingProgrammesTable::configure($table);
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
            'index' => ListTrainingProgrammes::route('/'),
            'create' => CreateTrainingProgramme::route('/create'),
            'edit' => EditTrainingProgramme::route('/{record}/edit'),
        ];
    }
}
