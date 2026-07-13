<?php

namespace App\Filament\Admin\Resources\PageSectionResource\Pages;

use App\Filament\Admin\Resources\PageSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageSection extends EditRecord
{
    protected static string $resource = PageSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Convert metadata (array from $casts) to repeater items
        if (isset($data['metadata']) && is_array($data['metadata'])) {
            $data['metadata_items'] = $data['metadata'];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Convert repeater items to metadata (array — $casts akan handle JSON encode)
        if (isset($data['metadata_items']) && is_array($data['metadata_items'])) {
            $data['metadata'] = $data['metadata_items'];
        } else {
            $data['metadata'] = [];
        }
        unset($data['metadata_items']);

        return $data;
    }
}
