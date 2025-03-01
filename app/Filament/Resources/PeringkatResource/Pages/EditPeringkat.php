<?php

namespace App\Filament\Resources\PeringkatResource\Pages;

use App\Filament\Resources\PeringkatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeringkat extends EditRecord
{
    protected static string $resource = PeringkatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
