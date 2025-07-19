<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Database\Eloquent\Model; // Import Model

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nik')
                    ->disabled()
                    ->maxLength(255),
                TextInput::make('name')
                    ->label('Nama')
                    ->maxLength(255),
                Section::make('Telegram Chat ID')
                    ->description('Informasi untuk mendapatkan Telegram Chat ID Anda')
                    ->schema([
                        Placeholder::make('telegram_tutorial')
                            ->content(view('filament.components.telegram-tutorial')),
                        TextInput::make('telegram_chat_id')
                            ->label('ID Telegram')
                            ->required()
                            ->helperText('Masukkan Chat ID Telegram yang telah Anda dapatkan dari langkah-langkah di atas')
                            ->maxLength(255),
                    ]),
                // Pastikan juga Anda memiliki field email dan password jika Anda ingin pengguna mengeditnya
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    // --- Tambahkan metode ini ---
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Panggil metode parent untuk menyimpan data default (name, email, password)
        // Jika Anda hanya ingin menyimpan telegram_chat_id, Anda bisa menghilangkan baris ini
        // dan hanya mengelola saving secara manual.
        $record = parent::handleRecordUpdate($record, $data);

        // Ambil data telegram_chat_id dari form
        $telegramChatId = $data['telegram_chat_id'] ?? null;

        // Update kolom telegram_chat_id di model User
        if ($record->telegram_chat_id !== $telegramChatId) {
            $record->forceFill([
                'telegram_chat_id' => $telegramChatId,
            ])->save();
        }

        return $record;
    }

    public function getRedirectUrl(): string
    {
        return '/admin';
    }
}