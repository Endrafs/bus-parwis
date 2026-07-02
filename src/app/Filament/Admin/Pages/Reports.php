<?php

namespace App\Filament\Admin\Pages;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Payment;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Laporan & Statistik';

    protected static string $view = 'filament.admin.pages.reports';

    public array $revenueData = [];

    public array $busStats = [];

    public string $totalPendapatan = '0';

    public int $totalBooking = 0;

    public int $totalBus = 0;

    public function mount(): void
    {
        $this->totalPendapatan = number_format(
            Payment::where('status_verifikasi', 'Disetujui')->sum('nominal'),
            0, ',', '.'
        );

        $this->totalBooking = Booking::whereNotIn('status', ['Dibatalkan'])->count();

        $this->totalBus = Bus::where('status', true)->count();

        // Stats per bus
        $this->busStats = Bus::withCount(['bookings' => function ($q) {
            $q->whereNotIn('status', ['Dibatalkan']);
        }])
            ->withSum(['bookings' => function ($q) {
                $q->whereNotIn('status', ['Dibatalkan']);
            }], 'total_harga')
            ->get()
            ->map(fn ($bus) => [
                'nama' => $bus->nama_bus,
                'kategori' => $bus->kategori_bus,
                'kapasitas' => $bus->kapasitas,
                'total_booking' => $bus->bookings_count,
                'total_pendapatan' => number_format($bus->bookings_sum_total_harga ?? 0, 0, ',', '.'),
                'status' => $bus->status ? 'Aktif' : 'Nonaktif',
            ])
            ->toArray();

        // Monthly revenue for current year
        $this->revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $this->revenueData[] = [
                'bulan' => date('F', mktime(0, 0, 0, $m, 1)),
                'total' => (int) Payment::where('status_verifikasi', 'Disetujui')
                    ->whereYear('tanggal_bayar', now()->year)
                    ->whereMonth('tanggal_bayar', $m)
                    ->sum('nominal'),
                'jumlah' => Payment::where('status_verifikasi', 'Disetujui')
                    ->whereYear('tanggal_bayar', now()->year)
                    ->whereMonth('tanggal_bayar', $m)
                    ->count(),
            ];
        }
    }
}
