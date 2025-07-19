<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TicketResource;
use Illuminate\Support\Facades\Auth;

class EditTicket extends EditRecord
{

    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        
        $recipient = Auth::user();

        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase($recipient);

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
