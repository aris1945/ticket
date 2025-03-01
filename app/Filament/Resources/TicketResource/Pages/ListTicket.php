<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Illuminate\Support\Facades\Auth;
use App\Filament\Exports\TicketExporter;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TicketResource;

class ListTIcket extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(TicketExporter::class)
                ->visible(fn () => !Auth::user()->hasRole('teknisi')),
            Actions\CreateAction::make(),
        ];
    }
}
