<?php

namespace App\Filament\Resources\TrainingRegistrations\Pages;

use App\Filament\Resources\TrainingRegistrations\TrainingRegistrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingRegistration extends EditRecord
{
    protected static string $resource = TrainingRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
