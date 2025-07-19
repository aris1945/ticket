<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini mengarah ke model User Anda
use Spatie\Permission\Models\Role; // Jika Anda menggunakan Spatie/Permission

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh data pengguna
        $userData = [
            'nik' => '18990339',
            'name' => 'Aris', // Ubah nama agar lebih deskriptif
            'email' => 'a@example.com',
            'password' => bcrypt('18990339'),
        ];

        // Buat atau update user
        $user = User::firstOrCreate(
            ['nik' => $userData['nik']], // Kriteria untuk mencari user yang sudah ada
            $userData
        );

        // Opsional: Berikan role jika Anda menggunakan Spatie/Permission
        // Pastikan role 'Super Admin' sudah ada (misalnya dari ShieldSeeder)
         if (Role::where('name', 'Super Admin')->exists()) {
             $user->assignRole('Super Admin');
         }
    }
}