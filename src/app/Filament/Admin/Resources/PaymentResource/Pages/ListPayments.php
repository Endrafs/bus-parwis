<?php

namespace App\Filament\Admin\Resources\PaymentResource\Pages;

use App\Filament\Admin\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pembayaran')
                ->icon('heroicon-o-plus'),

            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => null)
                ->color('gray'),
        ];
    }

    public function getTitle(): string
    {
        return 'Data Pembayaran';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola pembayaran DP maupun pelunasan pelanggan.';
    }
}