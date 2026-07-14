<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageSectionResource\Pages;
use App\Models\PageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?string $navigationLabel = 'Konten Halaman';
    protected static ?string $modelLabel = 'Konten Halaman';
    protected static ?string $pluralModelLabel = 'Konten Halaman';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Section')
                    ->schema([
                        Forms\Components\Select::make('page')
                            ->label('Halaman')
                            ->options([
                                'home' => 'Beranda (Home)',
                                'about' => 'Tentang (About)',
                                'services' => 'Layanan (Services)',
                                'contact' => 'Kontak (Contact)',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('section_key')
                            ->label('Key Section')
                            ->helperText('Identifier unik. Contoh: hero, about_content, stats')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Konten Text')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subjudul')
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'link',
                                'bulletList', 'orderedList',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->description('Upload gambar/video atau gunakan URL YouTube')
                    ->schema([
                        Forms\Components\Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'none' => 'Tidak Ada',
                                'image' => 'Gambar',
                                'video' => 'Video (Upload)',
                                'youtube' => 'YouTube Embed',
                                'gallery' => 'Galeri (Banyak Media)',
                            ])
                            ->default('none')
                            ->live()
                            ->required(),

                        Forms\Components\FileUpload::make('media_path')
                            ->label('File Media')
                            ->disk('public')
                            ->directory('page-media')
                            ->acceptedFileTypes([
                                'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/gif', 'image/*',
                                'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime',
                                'video/x-msvideo', 'video/x-matroska', 'video/*',
                            ])
                            ->maxSize(200000)
                            ->visible(fn (Forms\Get $get) => in_array($get('media_type'), ['image', 'video'])),

                        Forms\Components\TextInput::make('media_url')
                            ->label('URL YouTube')
                            ->helperText('Contoh: https://www.youtube.com/watch?v=xxxxx')
                            ->maxLength(255)
                            ->visible(fn (Forms\Get $get) => $get('media_type') === 'youtube'),

                        // Gallery repeater – hidden unless media_type === 'gallery'
                        Forms\Components\Repeater::make('media_items')
                            ->label('Item Galeri')
                            ->relationship('mediaItems')
                            ->schema([
                                Forms\Components\Select::make('media_type')
                                    ->label('Tipe')
                                    ->options([
                                        'image' => 'Gambar',
                                        'video' => 'Video',
                                        'youtube' => 'YouTube',
                                    ])
                                    ->required()
                                    ->live()
                                    ->default('image'),

                                Forms\Components\FileUpload::make('file_path')
                                    ->label('File')
                                    ->disk('public')
                                    ->directory('gallery')
                                    ->maxSize(200000)
                                    ->acceptedFileTypes([
                                        'image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/*',
                                        'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime',
                                        'video/x-msvideo', 'video/x-matroska', 'video/*',
                                    ])
                                    ->visible(fn (Forms\Get $get) => in_array($get('media_type'), ['image', 'video'])),

                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('URL YouTube')
                                    ->placeholder('https://youtube.com/watch?v=...')
                                    ->maxLength(255)
                                    ->visible(fn (Forms\Get $get) => $get('media_type') === 'youtube'),

                                Forms\Components\TextInput::make('caption')
                                    ->label('Caption')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->addActionLabel('Tambah Media')
                            ->defaultItems(0)
                            ->reorderable()
                            ->visible(fn (Forms\Get $get) => $get('media_type') === 'gallery'),
                    ]),

                Forms\Components\Section::make('Data Tambahan (Metadata)')
                    ->description('Gunakan untuk konten berulang seperti statistik, langkah proses, FAQ, nilai perusahaan, dll.')
                    ->schema([
                        Forms\Components\Repeater::make('metadata_items')
                            ->label('Item Data')
                            ->schema([
                                Forms\Components\TextInput::make('key')
                                    ->label('Key')
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('value')
                                    ->label('Value')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('label')
                                    ->label('Label')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('icon')
                                    ->label('Icon (emoji)')
                                    ->maxLength(50),
                                Forms\Components\Textarea::make('desc')
                                    ->label('Deskripsi')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->addActionLabel('Tambah Item')
                            ->defaultItems(0)
                            ->reorderable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page')
                    ->label('Halaman')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'home' => 'success',
                        'about' => 'info',
                        'services' => 'warning',
                        'contact' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'home' => 'Beranda',
                        'about' => 'Tentang',
                        'services' => 'Layanan',
                        'contact' => 'Kontak',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('section_key')
                    ->label('Section')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\IconColumn::make('media_type')
                    ->label('Media')
                    ->icon(fn (string $state): string => match ($state) {
                        'none' => 'heroicon-o-x-mark',
                        'image' => 'heroicon-o-photo',
                        'video' => 'heroicon-o-video-camera',
                        'youtube' => 'heroicon-o-play',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'none' => 'gray',
                        'image' => 'success',
                        'video' => 'warning',
                        'youtube' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->numeric(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('page', 'asc')
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('page')
                    ->label('Halaman')
                    ->options([
                        'home' => 'Beranda (Home)',
                        'about' => 'Tentang (About)',
                        'services' => 'Layanan (Services)',
                        'contact' => 'Kontak (Contact)',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSections::route('/'),
            'create' => Pages\CreatePageSection::route('/create'),
            'edit' => Pages\EditPageSection::route('/{record}/edit'),
        ];
    }
}
