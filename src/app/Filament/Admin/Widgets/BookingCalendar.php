<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BookingCalendar extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::with(['user', 'bus'])
                    ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                    ->orderBy('tanggal_berangkat')
                    ->limit(20)
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode_booking')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan'),

                Tables\Columns\TextColumn::make('bus.nama_bus')
                    ->label('Bus'),

                Tables\Columns\TextColumn::make('tujuan'),

                Tables\Columns\TextColumn::make('tanggal_berangkat')
                    ->label('Berangkat')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->label('Kembali')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('jumlah_hari')
                    ->label('Hari')
                    ->suffix(' hari'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Menunggu Verifikasi' => 'info',
                        'Dikonfirmasi' => 'success',
                        'Berjalan' => 'primary',
                        default => 'gray',
                    }),
            ])
            ->heading('📅 Kalender Booking — Mendatang')
            ->defaultSort('tanggal_berangkat', 'asc')
            ->paginated(false);
    }
}
