<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookings extends BaseWidget
{
    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::with(['user', 'bus'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode_booking')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan'),

                Tables\Columns\TextColumn::make('bus.nama_bus')
                    ->label('Bus'),

                Tables\Columns\TextColumn::make('tujuan'),

                Tables\Columns\TextColumn::make('tanggal_berangkat')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Menunggu Verifikasi' => 'info',
                        'Dikonfirmasi' => 'success',
                        'Berjalan' => 'primary',
                        'Selesai' => 'gray',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->heading('Booking Terbaru')
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
