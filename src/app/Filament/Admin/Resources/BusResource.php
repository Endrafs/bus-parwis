<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BusResource\Pages;
use App\Models\Bus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusResource extends Resource
{
    protected static ?string $model = Bus::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Bus';

    protected static ?string $modelLabel = 'Bus';

    protected static ?string $pluralModelLabel = 'Data Bus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informasi Bus')
                    ->schema([

                        Forms\Components\TextInput::make('nama_bus')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('kategori_bus')
                            ->options([
                                'Big Bus' => 'Big Bus',
                                'Medium Bus' => 'Medium Bus',
                                'Big Bus MHD' => 'Big Bus MHD',
                                'Travel Car' => 'Travel Car',
                            ])
                            ->required(),

                        Forms\Components\Select::make('tipe_bus')
                            ->options([
                                'Jetbus 5 SHD Single Glass' => 'Jetbus 5 SHD Single Glass',
                                'Jetbus 5 SHD' => 'Jetbus 5 SHD',
                                'Jetbus 3+ Medium High Deck Single Glass' => 'Jetbus 3+ Medium High Deck Single Glass',
                                'Jetbus 5 Medium Deck' => 'Jetbus 5 Medium Deck',
                                'Jetbus 5 Jumbo' => 'Jetbus 5 Jumbo',
                                'Travel' => 'Travel',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('kapasitas')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('harga_sewa')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\FileUpload::make('foto')
                            ->directory('bus')
                            ->image(),

                        Forms\Components\Toggle::make('status')
                            ->default(true),

                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fasilitas')
                    ->schema([

                        Forms\Components\CheckboxList::make('facilities')
                            ->relationship('facilities', 'nama_fasilitas')
                            ->columns(2),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                Tables\Columns\ImageColumn::make('foto')
                    ->square(),

                Tables\Columns\TextColumn::make('nama_bus')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('kategori_bus')
                    ->colors([
                        'primary',
                    ]),

                Tables\Columns\TextColumn::make('tipe_bus'),

                Tables\Columns\TextColumn::make('kapasitas')
                    ->suffix(' Seat'),

                Tables\Columns\TextColumn::make('harga_sewa')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\IconColumn::make('status')
                    ->boolean(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('kategori_bus')
                    ->options([
                        'Big Bus' => 'Big Bus',
                        'Medium Bus' => 'Medium Bus',
                        'Big Bus MHD' => 'Big Bus MHD',
                        'Travel Car' => 'Travel Car',
                    ]),

            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuses::route('/'),
            'create' => Pages\CreateBus::route('/create'),
            'edit' => Pages\EditBus::route('/{record}/edit'),
        ];
    }
}