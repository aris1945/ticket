<?php
 
namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
 
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
            ]);
    }

    public function getRedirectUrl(): string
    {
        return '/admin';
    }
}