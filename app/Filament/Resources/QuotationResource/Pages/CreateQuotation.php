<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    public Transaction $transaction;

    protected function getRedirectUrl(): string
    {
        return TransactionResource\Pages\TransactionDetails::getUrl([
            'record' => $this->transaction->getAttribute('id'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Hidden::make('transaction_id')
                    ->default($this->transaction->id)
                    ->live(),
                TextInput::make('cus_ref')
                    ->maxWidth('xl')
                    ->label('Cus Ref (Optional)')
                    ->placeholder('CUS REF')
                    ->nullable(),
                Textarea::make('attention')
                    ->maxWidth('xl')
                    ->nullable('Attention (Optional)')
                    ->placeholder('Attention')
                    ->nullable(),

            ]);
    }
}
