<?php

namespace App\Filament\Resources\TransactionResource\Pages\Traits;

use App\Filament\Resources\QuotationResource\Pages\CreateQuotation;
use App\Filament\Resources\QuotationResource\Pages\EditQuotation;
use App\Filament\Resources\TransactionResource\Pages\TransactionDetails;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;

/**
 * @mixin TransactionDetails
 */
trait HasHeaderFunctions
{
    protected function createInvoiceFromQuotationAction(): Action
    {
        return Action::make('create invoice')
            ->color(Color::Green);
    }

    protected function savePdfAction(): Action
    {
        return Action::make('save pdf')
            ->label('save pdf')
            ->color(Color::Blue)
            ->url(route('quotation.pdf', [
                'quotation' => $this->record->quotation->id,
            ]))
            ->openUrlInNewTab();
    }

    protected function getCreateQuotationAction(): Action
    {
        return Action::make('create quotation')
            ->icon('heroicon-o-plus')
            ->url(
                CreateQuotation::getUrl([
                    'transaction' => $this->record->getAttribute('id'),
                ])
            );
    }

    protected function getEditQuotationAction(): Action
    {
        return Action::make('edit quotation')
            ->icon('heroicon-o-pencil')
            ->url(
                EditQuotation::getUrl([
                    'record' => $this->record->quotation->getAttribute('id'),
                ])
            );
    }

    protected function createQuotationAction(): Action
    {
        return Action::make('create Quotation')
            ->color(Color::Blue)
            ->url(CreateQuotation::getUrl([
                'transaction' => $this->record->getAttribute('id'),
            ]));
    }
}
