<?php

namespace App\Filament\Admin\Resources\PageSectionResource\Pages;

use App\Filament\Admin\Resources\PageSectionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePageSection extends CreateRecord
{
    protected static string $resource = PageSectionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
