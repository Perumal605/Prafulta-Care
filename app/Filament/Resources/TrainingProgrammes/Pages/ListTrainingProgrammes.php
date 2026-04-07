<?php

namespace App\Filament\Resources\TrainingProgrammes\Pages;

use App\Filament\Resources\TrainingProgrammes\TrainingProgrammeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingProgrammes extends ListRecords
{
    protected static string $resource = TrainingProgrammeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
