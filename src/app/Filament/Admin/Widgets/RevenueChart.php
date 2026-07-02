<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan per Bulan (Disetujui)';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $year = now()->year;

        $labels = [];
        $data = [];

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        foreach ($months as $index => $month) {
            $labels[] = $month;

            $data[] = (int) Payment::where('status_verifikasi', 'Disetujui')
                ->whereYear('tanggal_bayar', $year)
                ->whereMonth('tanggal_bayar', $index)
                ->sum('nominal');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(249, 115, 22, 0.5)',
                    'borderColor' => 'rgb(249, 115, 22)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
