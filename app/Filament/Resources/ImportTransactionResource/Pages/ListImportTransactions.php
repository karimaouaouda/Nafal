<?php

namespace App\Filament\Resources\ImportTransactionResource\Pages;

use App\Filament\Resources\ImportTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImportTransactions extends ListRecords
{
    protected static string $resource = ImportTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
