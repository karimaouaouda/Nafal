<?php

namespace App\Filament\Resources\UnityResource\Pages;

use App\Filament\Resources\UnityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnities extends ListRecords
{
    protected static string $resource = UnityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
