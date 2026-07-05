<?php

namespace App\Filament\Admin\Resources\DestinationPriceResource\Pages;

use App\Filament\Admin\Resources\DestinationPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDestinationPrice extends EditRecord
{
    protected static string $resource = DestinationPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
