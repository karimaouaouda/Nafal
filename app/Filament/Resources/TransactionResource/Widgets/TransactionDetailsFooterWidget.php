<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Widgets\Widget;

class TransactionDetailsFooterWidget extends Widget
{
    use InteractsWithActions;
    protected static string $view = 'filament.resources.transaction-resource.widgets.transaction-details-footer-widget';

    public Transaction $record;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';


    public function getGenerateQuotationUrl(): string
    {
        return route('quotation.pdf', ['quotation' => $this->record->quotation]);
    }

    public function getGenerateInvoiceUrl(): string
    {
        return route('invoice.pdf', ['invoice' => $this->record->invoice]);
    }

    public function getGenerateReceiptUrl(): string
    {
        return route('receipt.pdf', ['receipt' => $this->record->receipt]);
    }
}
