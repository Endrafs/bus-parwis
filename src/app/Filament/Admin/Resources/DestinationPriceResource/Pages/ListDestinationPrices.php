<?php

namespace App\Filament\Admin\Resources\DestinationPriceResource\Pages;

use App\Filament\Admin\Resources\DestinationPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDestinationPrices extends ListRecords
{
    protected static string $resource = DestinationPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
