<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Supplier;
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

    protected static ?string $navigationGroup = 'products';

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
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
