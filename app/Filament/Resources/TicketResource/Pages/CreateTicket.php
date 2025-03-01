<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Models\User;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\SendTelegramNotification;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $ticket = static::getModel()::create($data);

        $nik = $data['assigned_to'];
        $recipient = User::where('nik', $nik)->first();

        if ($recipient) {
            // Kirim notifikasi ke database
            Notification::make()
                ->title('Anda Menerima Ticket Baru')
                ->body('Ticket Number : ' . $ticket->ticket_number)
                ->sendToDatabase($recipient);

            $telegramChatId = $recipient->telegram_chat_id;

            if ($telegramChatId) {
                $message = "Anda Menerima Ticket Baru\nTicket Number: " . $ticket->ticket_number;
                $recipient->notify(new SendTelegramNotification($message, $telegramChatId));
            }
        }

        return $ticket;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}