<?php

namespace App\Filament\Resources\PeringkatResource\Pages;

use App\Filament\Resources\PeringkatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeringkats extends ListRecords
{
    protected static string $resource = PeringkatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
