<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalBus = Bus::where('status', true)->count();
        $bookingAktif = Booking::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        $menungguVerifikasi = Payment::where('status_verifikasi', 'Menunggu')->count();
        $totalPendapatan = Payment::where('status_verifikasi', 'Disetujui')->sum('nominal');

        return [
            Stat::make('Armada Aktif', $totalBus . ' Bus')
                ->description('Siap disewa')
                ->descriptionIcon('heroicon-o-truck')
                ->color('success'),

            Stat::make('Booking Aktif', $bookingAktif)
                ->description('Sedang berjalan')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Menunggu Verifikasi', $menungguVerifikasi)
                ->description('Pembayaran perlu dicek')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Dari pembayaran disetujui')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),
        ];
    }
}
