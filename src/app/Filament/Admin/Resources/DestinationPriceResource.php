<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DestinationPriceResource\Pages;
use App\Models\DestinationPrice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DestinationPriceResource extends Resource
{
    protected static ?string $model = DestinationPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Harga Tujuan';

    protected static ?string $modelLabel = 'Harga Tujuan';

    protected static ?string $pluralModelLabel = 'Harga Tujuan';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Tujuan Wisata')
                    ->schema([
                        Forms\Components\TextInput::make('nama_tujuan')
                            ->label('Nama Tujuan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('harga')
                            ->label('Biaya Tujuan')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_tujuan')
                    ->label('Tujuan Wisata')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDestinationPrices::route('/'),
            'create' => Pages\CreateDestinationPrice::route('/create'),
            'edit' => Pages\EditDestinationPrice::route('/{record}/edit'),
        ];
    }
}
