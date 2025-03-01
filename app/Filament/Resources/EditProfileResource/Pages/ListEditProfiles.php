<?php

namespace App\Filament\Resources\EditProfileResource\Pages;

use App\Filament\Resources\EditProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEditProfiles extends ListRecords
{
    protected static string $resource = EditProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
