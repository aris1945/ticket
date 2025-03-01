<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TotalUserStats extends BaseWidget
{
    protected static ?int $sort = 2; // Atur urutan sesuai kebutuhan
    
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // Menghitung total pengguna
        $totalUsers = User::count();

        // Menghitung pengguna aktif (misalnya, berdasarkan kolom 'is_active')
        $activeUsers = User::where('is_active', true)->count();

        // Menghitung pengguna tidak aktif
        $inactiveUsers = User::where('is_active', false)->count();

        return [
            Stat::make(
                'Total Users',
                $totalUsers
            )->description('Jumlah total pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }

    public static function canView(): bool

    {

        // Memeriksa apakah pengguna yang sedang login memiliki peran 'super_admin'

        return Auth::check() && Auth::user()->hasRole('super_admin');

    }
}