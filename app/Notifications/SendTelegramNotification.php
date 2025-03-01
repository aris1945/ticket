<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $message;
    protected string $telegramChatId;

    public function __construct(string $message, string $telegramChatId)
    {
        $this->message = $message;
        $this->telegramChatId = $telegramChatId;
    }

    public function via($notifiable): array
    {
        return ['database', 'telegram'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => $this->message,
        ];
    }

    public function toTelegram($notifiable)
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramChatId,
            'text' => $this->message,
        ]);
    }
}