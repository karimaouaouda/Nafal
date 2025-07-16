<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    public function form(Form $form): Form
    {
        $createPage = (new CreateQuotation);
        $createPage->transaction = $this->record->transaction;

        return $createPage->form($form);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('go back')
                ->url(fn ($record) => TransactionResource\Pages\TransactionDetails::getUrl([
                    'record' => $record->transaction->id,
                ])),
        ];
    }
}
