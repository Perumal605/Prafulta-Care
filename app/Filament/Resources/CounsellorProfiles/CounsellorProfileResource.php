<?php

namespace App\Filament\Resources\CounsellorProfiles;

use App\Filament\Resources\CounsellorProfiles\Pages\CreateCounsellorProfile;
use App\Filament\Resources\CounsellorProfiles\Pages\EditCounsellorProfile;
use App\Filament\Resources\CounsellorProfiles\Pages\ListCounsellorProfiles;
use App\Filament\Resources\CounsellorProfiles\Schemas\CounsellorProfileForm;
use App\Filament\Resources\CounsellorProfiles\Tables\CounsellorProfilesTable;
use App\Models\CounsellorProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CounsellorProfileResource extends Resource
{
    protected static ?string $model = CounsellorProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CounsellorProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CounsellorProfilesTable::configure($table);
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
            'index' => ListCounsellorProfiles::route('/'),
            'create' => CreateCounsellorProfile::route('/create'),
            'edit' => EditCounsellorProfile::route('/{record}/edit'),
        ];
    }
}
