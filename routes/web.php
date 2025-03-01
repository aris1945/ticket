<?php

use App\Models\User;

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Notifications\TelegramNotification;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-message', function () {
    $chatId = '5424608504'; // Replace with your chat ID
    $message = 'Hello, this is a message from Laravel!';

    Telegram::sendMessage([
        'chat_id' => $chatId,
        'text' => $message,
    ]);

    return 'Message sent to Telegram!';
});

