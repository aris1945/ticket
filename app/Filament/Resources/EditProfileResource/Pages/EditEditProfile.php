<?php

namespace App\Filament\Resources\EditProfileResource\Pages;

use App\Filament\Resources\EditProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEditProfile extends EditRecord
{
    protected static string $resource = EditProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
