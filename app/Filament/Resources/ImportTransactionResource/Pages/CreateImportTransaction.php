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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
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
                            Checkbox::make('is_product_exists')
                                    ->live()
                                    ->default(true),
                            Select::make('product_id')
                                ->live()
                                ->preload()
                                ->searchable()
                                ->required()
                                ->visible(function(Get $get) {
                                    return $get('is_product_exists');
                                })
                                ->options(function(){
                                    $products = Product::all();
                                    // product : id = name-sku
                                    $options = [];

                                    $products->each(function($product) use (&$options) {
                                        $options[$product->id] = sprintf("%s - %s", $product->description, $product->sku);
                                    });

                                    return $options;
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
                            Checkbox::make('is_delivery_free')
                                ->live()
                                ->label('Is Delivery Free?')
                                ->default(true),
                            Forms\Components\TextInput::make('delivery_price')
                                ->visible(fn(Forms\Get $get) => !$get('is_delivery_free'))
                                ->label('Delivery Price')
                                ->required()
                                ->numeric(),
                        ]),
                    Forms\Components\Wizard\Step::make('Product Basic Information')
                        ->visible(fn(Forms\Get $get) => !$get('is_product_exists'))
                        ->schema([
                            Forms\Components\Select::make('product.category_id')
                                ->label('Category')
                                ->relationship('category')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->required(),

                            Forms\Components\Select::make('product.unity_id')
                                ->preload()
                                ->options(function(){
                                    $all = Unity::all();

                                    $options = [];
                                    $all->each(function(Unity $item) use (&$options){
                                        $options[$item->getAttribute('id')] = sprintf("%s (%s)", $item->name, $item->abbreviation);
                                    });

                                    return $options;
                                })
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
                        ->visible(fn(Forms\Get $get) => !$get('is_product_exists'))
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
            return DB::transaction(function () use ($data){
                if( ! $data['is_product_exists'] ){
                    $product = Product::query()->create($data['product']);
                }else{
                    $product = Product::query()->findOrFail($data['product_id']);
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
