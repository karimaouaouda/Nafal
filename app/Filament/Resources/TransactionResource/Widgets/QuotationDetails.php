<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\Transaction;
use Filament\Resources\Concerns\InteractsWithRelationshipTable;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuotationDetails extends Widget
{
    protected static string $view = 'filament.resources.transaction-resource.widgets.quotation-details';

    public ViewRecord $page;

    protected int | string | array $columnSpan = 2;
    protected static bool $isLazy = false;

    public Transaction $record;

    public Quotation|null $quotation;

    public function toCreateQuotation(): void
    {
        $this->redirectIntended(route('filament.admin.resources.quotations.create', [
            'transaction' => $this->record,
        ]), false);
    }

    public function mount(): void
    {
        $this->quotation = $this->record->quotation ?? null;
    }

}
