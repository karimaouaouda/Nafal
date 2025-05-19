<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\QuotationResource\Pages\CreateQuotation;
use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Config;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return  $infolist->schema([
            Section::make('customer information')
                ->schema([
                    TextEntry::make('id')
                        ->prefix('#')
                        ->extraAttributes([
                            'class' => 'font-bold'
                        ], true),
                    TextEntry::make('customer.latin_name')
                        ->badge()
                ])->columns(2)
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TransactionResource\Widgets\TransactionProceed::class,
            TransactionResource\Widgets\QuotationDetails::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->quotationAction()
        ];
    }

    private function quotationAction(): Actions\Action
    {
        $quotation = $this->record->quotation;
        return is_null($quotation) ?
            Actions\Action::make('new quotation')
                ->icon('heroicon-o-plus')
                ->openUrlInNewTab()
                ->url(
                    CreateQuotation::getUrl([
                        'transaction' => $this->record->getAttribute('id')
                    ])
                ) :
            Actions\Action::make('view quotation')
                ->color(Color::Gray)
                ->form([
                    TextInput::make('cus_ref')
                        ->default($quotation->getAttribute('cus_ref'))
                        ->readOnly(),
                    Textarea::make('attention')
                        ->default($quotation->getAttribute('attention'))
                        ->readOnly()
                ])
                ->modalSubmitAction(false)
                ->icon('heroicon-o-eye');
    }
}
