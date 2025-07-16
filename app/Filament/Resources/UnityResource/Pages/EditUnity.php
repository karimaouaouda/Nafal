<?php

namespace App\Filament\Resources\UnityResource\Pages;

use App\Filament\Resources\UnityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnity extends EditRecord
{
    protected static string $resource = UnityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
