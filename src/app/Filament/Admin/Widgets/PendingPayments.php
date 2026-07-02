<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingPayments extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::where('status_verifikasi', 'Menunggu')
                    ->with('booking.user')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('booking.kode_booking')
                    ->label('Kode Booking')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking.user.name')
                    ->label('Pelanggan'),

                Tables\Columns\TextColumn::make('jenis_pembayaran')
                    ->badge(),

                Tables\Columns\TextColumn::make('nominal')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload')
                    ->dateTime('d M Y H:i'),
            ])
            ->heading('Pembayaran Menunggu Verifikasi')
            ->defaultSort('created_at', 'desc');
    }
}
