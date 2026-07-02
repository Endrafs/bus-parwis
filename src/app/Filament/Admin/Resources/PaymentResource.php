<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentResource\Pages;
use App\Models\Booking;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Data Pembayaran')
                ->schema([

                    Forms\Components\Select::make('booking_id')
                        ->label('Booking')
                        ->relationship('booking', 'kode_booking')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\Select::make('jenis_pembayaran')
                        ->options([
                            'DP' => 'DP',
                            'Pelunasan' => 'Pelunasan',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('nominal')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    Forms\Components\DatePicker::make('tanggal_bayar')
                        ->native(false)
                        ->default(now())
                        ->required(),

                    Forms\Components\FileUpload::make('bukti_transfer')
                        ->directory('payments')
                        ->image()
                        ->imageEditor()
                        ->downloadable()
                        ->openable()
                        ->required(),

                    Forms\Components\Select::make('status_verifikasi')
                        ->options([
                            'Menunggu' => 'Menunggu',
                            'Disetujui' => 'Disetujui',
                            'Ditolak' => 'Ditolak',
                        ])
                        ->default('Menunggu')
                        ->required(),

                    Forms\Components\Textarea::make('catatan')
                        ->rows(4)
                        ->columnSpanFull(),

                ])
                ->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                Tables\Columns\TextColumn::make('booking.kode_booking')
                    ->label('Kode Booking')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking.user.name')
                    ->label('Pelanggan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_pembayaran')
                    ->badge(),

                Tables\Columns\TextColumn::make('nominal')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Menunggu' => 'warning',
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->date('d M Y'),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('jenis_pembayaran')
                    ->options([
                        'DP' => 'DP',
                        'Pelunasan' => 'Pelunasan',
                    ]),

            ])

            ->actions([

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record) => $record->status_verifikasi === 'Menunggu')
                    ->action(function (Payment $record) {

                        $record->update([
                            'status_verifikasi' => 'Disetujui',
                        ]);

                        $record->booking->update([
                            'status' => 'Dikonfirmasi',
                        ]);
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record) => $record->status_verifikasi === 'Menunggu')
                    ->action(function (Payment $record) {

                        $record->update([
                            'status_verifikasi' => 'Ditolak',
                        ]);

                        $record->booking->update([
                            'status' => 'Pending',
                        ]);
                    }),

                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make(),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}