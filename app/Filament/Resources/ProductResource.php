<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Wizard::make()
                    ->schema([
                        Forms\Components\Wizard\Step::make('appearance')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->preload()
                                    ->prefixIcon('heroicon-o-tag')
                                    ->required()
                                    ->searchable(),
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->placeholder('Product title')
                                    ->prefixIcon('heroicon-o-pencil'),
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->placeholder('Product description'),
                            ]),
                        Forms\Components\Wizard\Step::make('necessery informations')
                            ->schema([
                                Forms\Components\TextInput::make('number')
                                    ->required()
                                    ->hint('this number must be unique')
                                    ->placeholder('Product number')
                                    ->prefixIcon('heroicon-o-language'),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0.0)
                                    ->placeholder('Product price')
                                    ->prefixIcon('heroicon-o-currency-dollar')
                                    ->prefixIconColor(Color::Green),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->integer()
                                    ->minValue(0)
                                    ->placeholder('Product quantity')
                                    ->prefixIcon('heroicon-o-inbox-stack')
                                    ->prefixIconColor(Color::Blue),
                                Forms\Components\Textarea::make('remark')
                                    ->nullable()
                                    ->placeholder('Product remark (Optional)'),
                            ]),
                        Forms\Components\Wizard\Step::make('media')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->nullable()
                                    ->label('Product image (Optional)')
                                    ->disk('public')
                                    ->directory('products/images'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->prefix('#')
                    ->extraAttributes([
                        'class' => 'font-bold',
                    ], true),
                Tables\Columns\TextColumn::make('number')
                    ->badge(),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge(),
                Tables\Columns\ImageColumn::make('image')
                    ->default(asset('images/product-default.jpeg'))
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->tooltip(fn ($state) => $state)
                    ->words(5)
                    ->label('title')
                    ->description(fn (Product $record) => $record->getAttribute('description'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('price')
                    ->badge()
                    ->color(Color::Green)
                    ->icon('heroicon-o-currency-dollar'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('quantity')
                    ->badge()
                    ->color(Color::Orange),
                Tables\Columns\TextColumn::make('remark')
                    ->words(5)
                    ->tooltip(fn ($state) => $state),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
