<?php

namespace App\Filament\Admin\Resources\PaymentResource\Pages;

use App\Filament\Admin\Resources\PaymentResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function afterSave(): void
    {
        $payment = $this->record;

        if ($payment->status_verifikasi === 'Disetujui') {
            $payment->booking()->update([
                'status' => 'Dikonfirmasi',
            ]);
        }

        if ($payment->status_verifikasi === 'Ditolak') {
            $payment->booking()->update([
                'status' => 'Pending',
            ]);
        }

        Notification::make()
            ->title('Data pembayaran berhasil diperbarui.')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Pembayaran berhasil dihapus'),
        ];
    }
}