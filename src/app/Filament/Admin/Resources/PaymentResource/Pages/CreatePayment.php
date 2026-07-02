<?php

namespace App\Filament\Admin\Resources\PaymentResource\Pages;

use App\Filament\Admin\Resources\PaymentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function afterCreate(): void
    {
        $payment = $this->record;

        if ($payment->status_verifikasi === 'Disetujui') {
            $payment->booking()->update([
                'status' => 'Dikonfirmasi',
            ]);
        }

        Notification::make()
            ->title('Pembayaran berhasil ditambahkan.')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}