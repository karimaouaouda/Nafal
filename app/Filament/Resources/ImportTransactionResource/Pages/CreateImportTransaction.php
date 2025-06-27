<?php

namespace App\Filament\Resources\ImportTransactionResource\Pages;

use App\Filament\Resources\ImportTransactionResource;
use App\Models\Category;
use App\Models\ImportTransaction;
use App\Models\Product;
use App\Models\Unity;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateImportTransaction extends CreateRecord
{
    protected static string $resource = ImportTransactionResource::class;


    public bool $productExists = false;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('ImportTransaction Information')
                        ->schema([
                            Forms\Components\Select::make('supplier_id')
                                ->label('Supplier')
                                ->options(\App\Models\Supplier::all()->pluck('name' ,'id'))
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\TextInput::make('product.sku')
                                ->label('Product SKU')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, ?string $state) {
                                    $exists = \App\Models\Product::query()->where('sku', $state)->exists();
                                    $set('product_section_visible', !$exists);
                                }),
                            Forms\Components\TextInput::make('buy_price')
                                ->label('Buy Price')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('quantity')
                                ->label('Quantity')
                                ->required()
                                ->numeric(),
                            Forms\Components\Select::make('payment_method')
                                ->label('Payment Method')
                                ->options([
                                    'cash' => 'Cash',
                                    'credit' => 'Credit',
                                    'transfer' => 'Bank Transfer',
                                ])
                                ->required(),
                            Forms\Components\Select::make('delivery_type')
                                ->label('Delivery Type')
                                ->options([
                                    'standard' => 'Standard',
                                    'express' => 'Express',
                                    'pickup' => 'Pick Up',
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('delivery_price')
                                ->label('Delivery Price')
                                ->required()
                                ->numeric(),
                        ]),
                    Forms\Components\Wizard\Step::make('Product Basic Information')
                        ->visible(fn(Forms\Get $get) => $get('product_section_visible'))
                        ->schema([
                            Forms\Components\Select::make('product.category_id')
                                ->label('Category')
                                ->relationship('category')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->required(),

                            Forms\Components\Select::make('product.unity_id')
                                ->preload()
                                ->options(Unity::all()->pluck('abbreviation', 'id'))
                                ->label('Unity ID')
                                ->required(),

                            Forms\Components\TextInput::make('product.sku')
                                ->label('SKU')
                                ->unique('products', 'sku')
                                ->required(),

                            Forms\Components\TextInput::make('product.title')
                                ->label('Title')
                                ->required(),

                            Forms\Components\Textarea::make('product.description')
                                ->label('Description')
                                ->required(),

                            Forms\Components\FileUpload::make('product.sheets')
                                ->multiple()
                                ->label('Sheets'),

                            Forms\Components\Textarea::make('product.remark')
                                ->label('Remark'),
                        ]),
                    Forms\Components\Wizard\Step::make('Product image')
                        ->visible(fn(Forms\Get $get) => $get('product_section_visible'))
                        ->schema([
                            Forms\Components\FileUpload::make('product.image')
                                ->label('Upload Product Logo'),
                        ]),
                ]),
            ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        try{
            $product_sku = $data['product']['sku'];
            // check if already exists
            $product = null;
            if( Product::query()->where('sku', $product_sku)->exists() ){
                $this->productExists = true;
                $product = Product::query()->where('sku', $product_sku)->first();
            }


            return DB::transaction(function () use ($data, $product){
                if( !$this->productExists ){
                    $product = Product::query()->create($data['product']);
                }

                $data['product_id'] = $product->id;

                return ImportTransaction::query()->create($data);
            });
        }catch (\Exception $e){
            Notification::make()
                ->danger()
                ->title('error occurred when creating ur transaction')
                ->body($e->getMessage())
                ->send();
            throw $e;
        }
    }
}
