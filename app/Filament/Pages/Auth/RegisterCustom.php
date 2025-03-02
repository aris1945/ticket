<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()->schema([
                    Forms\Components\TextInput::make('nik')
                        ->label('NIK')
                        ->required()
                        ->maxLength(16), // Sesuaikan panjang NIK jika perlu
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->required()
                        ->password()
                        ->minLength(8), // Sesuaikan panjang password jika perlu
                ])->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Simpan pengguna baru ke database
        $user = User::create([
            'nik' => $data['nik'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // Kembalikan model pengguna yang baru dibuat
        return $user;
    }
}