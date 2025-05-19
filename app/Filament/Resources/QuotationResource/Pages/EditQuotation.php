<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\TransactionResource;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    public function form(Form $form) : Form
    {
        $createPage = (new CreateQuotation());
        $createPage->transaction = $this->record->transaction;
        return $createPage->form($form);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('go back')
                ->url(fn($record) => TransactionResource\Pages\ViewTransaction::getUrl([
                    'record' => $record->id,
                ]))
        ];
    }
}
