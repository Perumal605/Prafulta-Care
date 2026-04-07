<?php

namespace App\Filament\Resources\TrainingProgrammes\Pages;

use App\Filament\Resources\TrainingProgrammes\TrainingProgrammeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingProgramme extends EditRecord
{
    protected static string $resource = TrainingProgrammeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
