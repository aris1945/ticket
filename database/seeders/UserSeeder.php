<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nik' => '19930270', // NIK contoh
            'name' => '19930270',
            'email' => 'a@example.com',
            'password' => bcrypt('19930270'), // Hashing password agar aman
        ]);
    }
}
