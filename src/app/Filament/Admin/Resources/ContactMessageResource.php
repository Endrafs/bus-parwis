<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Pesan Masuk';

    protected static ?string $modelLabel = 'Pesan';

    protected static ?string $pluralModelLabel = 'Pesan Masuk';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::baru()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Pengirim')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama')
                            ->label('Nama'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->placeholder('-'),
                        Infolists\Components\TextEntry::make('no_wa')
                            ->label('No WhatsApp'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Diterima pada')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Pesan')
                    ->schema([
                        Infolists\Components\TextEntry::make('pesan')
                            ->label('Isi Pesan')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Balasan')
                    ->schema([
                        Infolists\Components\TextEntry::make('balasan')
                            ->label('Isi Balasan')
                            ->markdown()
                            ->placeholder('Belum ada balasan')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('dibalasOleh.name')
                            ->label('Dibalas oleh')
                            ->placeholder('-'),
                        Infolists\Components\TextEntry::make('dibalas_pada')
                            ->label('Dibalas pada')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'baru' ? 'danger' : 'success')
                            ->formatStateUsing(fn (string $state): string => $state === 'baru' ? 'Baru' : 'Dibalas'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengirim')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('no_wa')
                            ->label('No WhatsApp')
                            ->required()
                            ->maxLength(20),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Pesan')
                    ->schema([
                        Forms\Components\Textarea::make('pesan')
                            ->required()
                            ->maxLength(1000)
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'baru' => 'Baru',
                                'dibalas' => 'Dibalas',
                            ])
                            ->default('baru')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->description(fn (ContactMessage $record): string => $record->no_wa),

                Tables\Columns\TextColumn::make('pesan')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (ContactMessage $record): string => $record->pesan),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'baru',
                        'success' => 'dibalas',
                    ])
                    ->formatStateUsing(fn (string $state): string => $state === 'baru' ? 'Baru' : 'Dibalas'),

                Tables\Columns\TextColumn::make('dibalasOleh.name')
                    ->label('Dibalas Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('dibalas_pada')
                    ->label('Dibalas')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'baru' => 'Baru',
                        'dibalas' => 'Dibalas',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}