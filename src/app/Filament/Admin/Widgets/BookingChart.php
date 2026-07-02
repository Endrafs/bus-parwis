<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookingChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Booking per Bulan';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $year = now()->year;

        $labels = [];
        $totalData = [];
        $dikonfirmasiData = [];

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        foreach ($months as $index => $month) {
            $labels[] = $month;

            $totalData[] = Booking::whereYear('tanggal_berangkat', $year)
                ->whereMonth('tanggal_berangkat', $index)
                ->whereNotIn('status', ['Dibatalkan'])
                ->count();

            $dikonfirmasiData[] = Booking::whereYear('tanggal_berangkat', $year)
                ->whereMonth('tanggal_berangkat', $index)
                ->whereIn('status', ['Dikonfirmasi', 'Berjalan', 'Selesai'])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Booking',
                    'data' => $totalData,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.5)',
                    'borderColor' => 'rgb(99, 102, 241)',
                ],
                [
                    'label' => 'Dikonfirmasi',
                    'data' => $dikonfirmasiData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
