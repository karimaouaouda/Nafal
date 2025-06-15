<?php

namespace App\Filament\Resources\ImportTransactionResource\Pages;

use App\Filament\Resources\ImportTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImportTransaction extends EditRecord
{
    protected static string $resource = ImportTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
