<?php

namespace App\Filament\Admin\Resources\ContactMessageResource\Pages;

use App\Filament\Admin\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('balas')
                ->label('Balas Pesan')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->form([
                    Textarea::make('balasan')
                        ->label('Isi Balasan')
                        ->required()
                        ->rows(5)
                        ->maxLength(2000)
                        ->placeholder('Tulis balasan untuk pengirim...'),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'balasan' => $data['balasan'],
                        'dibalas_pada' => now(),
                        'dibalas_oleh' => auth()->id(),
                        'status' => 'dibalas',
                    ]);

                    Notification::make()
                        ->title('Balasan berhasil disimpan!')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'baru'),

            Actions\Action::make('edit_balasan')
                ->label('Edit Balasan')
                ->icon('heroicon-o-pencil-square')
                ->color('warning')
                ->form([
                    Textarea::make('balasan')
                        ->label('Isi Balasan')
                        ->required()
                        ->rows(5)
                        ->maxLength(2000)
                        ->default(fn () => $this->record->balasan),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'balasan' => $data['balasan'],
                    ]);

                    Notification::make()
                        ->title('Balasan berhasil diperbarui!')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'dibalas'),

            Actions\DeleteAction::make(),
        ];
    }
}