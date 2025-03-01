<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserTicketStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $userNik = auth()->user()->nik;

        $totalTickets = Ticket::where('assigned_to', $userNik)->count();
        $assignedTickets = Ticket::where('assigned_to', $userNik)
            ->where('status', 'assigned')
            ->count();
        $doneTickets = Ticket::where('assigned_to', $userNik)
            ->where('status', 'done')
            ->count();
        $psbTickets = Ticket::where('assigned_to', $userNik)
            ->where('category', 'psb')
            ->count();
        $ggnTickets = Ticket::where('assigned_to', $userNik)
            ->where('category', 'ggn')
            ->count();

        return [
            Stat::make('My Tickets', $totalTickets)
                ->description('Total ticket yang ditugaskan kepada Anda')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),

            Stat::make('In Progress', $assignedTickets)
                ->description('Ticket dalam proses pengerjaan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(
                'Completed',
                $doneTickets
            )->description('Ticket yang sudah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'PSB Tickets',
                $psbTickets
            )->description('Total ticket PSB yang ditugaskan kepada Anda')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),

            Stat::make(
                'GGN Tickets',
                $ggnTickets
            )->description('Total ticket GGN yang ditugaskan kepada Anda')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
