<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        // Kembalikan array kosong atau hapus metode ini jika tidak menggunakan driver
        return [];
    }

    public function toTelegram($notifiable)
    {
        $client = new Client();
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Simpan token bot di .env
        $chatId = $notifiable->telegram_chat_id;

        if (!$chatId) {
            Log::error('Telegram Chat ID tidak ditemukan untuk user: ' . $notifiable->id);
            return;
        }

        try {
            $client->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'form_params' => [
                    'chat_id' => $chatId,
                    'text' => $this->message,
                ],
            ]);
            Log::info('Notifikasi Telegram berhasil dikirim ke chat ID: ' . $chatId);
        } catch (GuzzleException $e) {
            Log::error('Gagal mengirim notifikasi Telegram: ' . $e->getMessage());
        }
    }
}