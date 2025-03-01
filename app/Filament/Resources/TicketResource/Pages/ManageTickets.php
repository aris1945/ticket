<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Exports\TicketExporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use App\Filament\Resources\TicketResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageTickets extends ManageRecords
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
