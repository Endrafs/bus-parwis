<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Bus;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Booking';

    protected static ?string $modelLabel = 'Booking';

    protected static ?string $pluralModelLabel = 'Booking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informasi Booking')
                    ->schema([

                        Forms\Components\TextInput::make('kode_booking')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Otomatis dibuat'),

                        Forms\Components\Select::make('user_id')
                            ->label('Pelanggan')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('bus_id')
                            ->label('Bus')
                            ->relationship('bus', 'nama_bus')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                if (!$get('tanggal_berangkat') || !$get('tanggal_kembali')) {
                                    return;
                                }

                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\DatePicker::make('tanggal_berangkat')
                            ->native(false)
                            ->minDate(now())
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\DatePicker::make('tanggal_kembali')
                            ->native(false)
                            ->after('tanggal_berangkat')
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('tujuan')
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_hari')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('harga_sewa_unit')
                            ->label('Harga Sewa Unit / Hari')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('biaya_tol')
                            ->label('Biaya Tol')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('biaya_solar')
                            ->label('Biaya Solar')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('tips_crew')
                            ->label('Tips Crew Bus')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('biaya_parkir')
                            ->label('Biaya Parkir')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('biaya_tujuan')
                            ->label('Biaya Tujuan Wisata')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTotal($get, $set);
                            }),

                        Forms\Components\TextInput::make('total_harga')
                            ->prefix('Rp')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                                'Dikonfirmasi' => 'Dikonfirmasi',
                                'Berjalan' => 'Berjalan',
                                'Selesai' => 'Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('Pending')
                            ->required(),

                        Forms\Components\Textarea::make('catatan')
                            ->rows(4)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),
            ]);
    }

    protected static function calculateTotal(Get $get, Set $set): void
    {
        if (
            !$get('bus_id') ||
            !$get('tanggal_berangkat') ||
            !$get('tanggal_kembali')
        ) {
            return;
        }

        $bus = Bus::find($get('bus_id'));

        if (!$bus) {
            return;
        }

        $start = Carbon::parse($get('tanggal_berangkat'));
        $end = Carbon::parse($get('tanggal_kembali'));

        if ($end->lessThan($start)) {
            return;
        }

        $days = $start->diffInDays($end) + 1;

        $hargaSewaUnit = (float) ($get('harga_sewa_unit') ?? $bus->harga_sewa);
        $biayaTol = (float) ($get('biaya_tol') ?? 0);
        $biayaSolar = (float) ($get('biaya_solar') ?? 0);
        $tipsCrew = (float) ($get('tips_crew') ?? 0);
        $biayaParkir = (float) ($get('biaya_parkir') ?? 0);
        $biayaTujuan = (float) ($get('biaya_tujuan') ?? 0);

        $set('jumlah_hari', $days);
        $set('harga_sewa_unit', $hargaSewaUnit);
        $set('biaya_tol', $biayaTol);
        $set('biaya_solar', $biayaSolar);
        $set('tips_crew', $tipsCrew);
        $set('biaya_parkir', $biayaParkir);
        $set('biaya_tujuan', $biayaTujuan);

        $total = Booking::hitungTotalHarga($hargaSewaUnit, $days, $biayaTol, $biayaSolar, $tipsCrew, $biayaParkir, $biayaTujuan);
        $set('total_harga', $total);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('kode_booking')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bus.nama_bus')
                    ->label('Bus')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_berangkat')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('jumlah_hari')
                    ->suffix(' Hari'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Menunggu Verifikasi' => 'info',
                        'Dikonfirmasi' => 'success',
                        'Berjalan' => 'primary',
                        'Selesai' => 'gray',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i'),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Dikonfirmasi' => 'Dikonfirmasi',
                        'Berjalan' => 'Berjalan',
                        'Selesai' => 'Selesai',
                        'Dibatalkan' => 'Dibatalkan',
                    ]),

                Tables\Filters\SelectFilter::make('bus')
                    ->relationship('bus', 'nama_bus'),

            ])

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // Konfirmasi Booking (dari Menunggu Verifikasi → Dikonfirmasi)
                Tables\Actions\Action::make('konfirmasi')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => $record->status === 'Menunggu Verifikasi')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'Dikonfirmasi']);
                    }),

                // Mulai Perjalanan (dari Dikonfirmasi → Berjalan)
                Tables\Actions\Action::make('mulai')
                    ->label('Mulai Berjalan')
                    ->icon('heroicon-o-play-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => $record->status === 'Dikonfirmasi')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'Berjalan']);
                    }),

                // Selesaikan (dari Berjalan → Selesai)
                Tables\Actions\Action::make('selesai')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-flag')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => $record->status === 'Berjalan')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'Selesai']);
                    }),

                // Batalkan
                Tables\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => ! in_array($record->status, ['Selesai', 'Dibatalkan']))
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'Dibatalkan']);
                    }),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}