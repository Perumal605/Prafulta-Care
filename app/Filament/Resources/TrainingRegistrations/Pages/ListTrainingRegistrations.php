<?php

namespace App\Filament\Resources\TrainingRegistrations\Pages;

use App\Filament\Resources\TrainingRegistrations\TrainingRegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingRegistrations extends ListRecords
{
    protected static string $resource = TrainingRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
