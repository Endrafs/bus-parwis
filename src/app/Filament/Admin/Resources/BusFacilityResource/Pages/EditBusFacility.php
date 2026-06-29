<?php

namespace App\Filament\Admin\Resources\BusFacilityResource\Pages;

use App\Filament\Admin\Resources\BusFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusFacility extends EditRecord
{
    protected static string $resource = BusFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
