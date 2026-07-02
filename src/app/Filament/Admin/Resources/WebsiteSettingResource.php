<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WebsiteSettingResource\Pages;
use App\Filament\Admin\Resources\WebsiteSettingResource\RelationManagers;
use App\Models\WebsiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebsiteSettingResource extends Resource
{
    protected static ?string $model = WebsiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Pengaturan Website';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Website')
                    ->description('Pengaturan utama yang akan tampil di halaman depan.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_website')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Website')
                            ->image()
                            ->directory('website')
                            ->imageEditor(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Website')
                            ->rows(3)
                            ->maxLength(500),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->helperText('Format: 6281234567890')
                            ->maxLength(20),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(2),

                        Forms\Components\Textarea::make('rekening_bank')
                            ->label('Info Rekening Bank')
                            ->helperText('Contoh: BCA 1234567890 a.n. PT Bus Parwis')
                            ->rows(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_website')
                    ->label('Nama Website')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('logo')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebsiteSettings::route('/'),
            'create' => Pages\CreateWebsiteSetting::route('/create'),
            'edit' => Pages\EditWebsiteSetting::route('/{record}/edit'),
        ];
    }
}
