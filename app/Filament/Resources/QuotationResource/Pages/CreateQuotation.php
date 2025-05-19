<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    public Transaction $transaction;



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
                    Repeater::make('products')
                        ->schema([
                            Select::make('product_id')
                                ->options(
                                    Product::all()->pluck('title', 'id')
                                ),
                            TextInput::make('sold')
                                ->default(0)
                                ->prefix('%'),
                            TextInput::make('discount')
                                ->default(0)
                                ->prefix('$')
                        ])
                ]);
    }
}
