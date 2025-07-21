<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImportTransactionResource\Pages;
use App\Filament\Resources\ImportTransactionResource\RelationManagers;
use App\Models\ImportTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImportTransactionResource extends Resource
{
    protected static ?string $model = ImportTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationGroup = "transactions";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('transaction id')
                    ->sortable()
                    ->badge()
                    ->limit(15)
                    ->tooltip(fn($state) => $state)
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.title')
                    ->label('Product')
                    ->sortable()
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('buy_price')
                    ->label('Buy Price')
                    ->sortable()
                    ->money('USD')
                    ->badge()
                    ->color(Color::Green),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->badge()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->color(Color::Blue),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable()
                    ->badge()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->color(Color::Purple),

                Tables\Columns\TextColumn::make('delivery_type')
                    ->label('Delivery Type')
                    ->sortable()
                    ->badge()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->color(Color::Yellow),

                Tables\Columns\TextColumn::make('delivery_price')
                    ->label('Delivery Price')
                    ->sortable()
                    ->money('USD')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->badge()
                    ->color(Color::Teal),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->badge()
                    ->color(Color::Green),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('supplier_id')
                    ->relationship('supplier', 'latin_name')
                    ->label('Supplier'),
                Tables\Filters\SelectFilter::make('product_id')
                    ->relationship('product', 'title')
                    ->label('Product'),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'credit' => 'Credit Card',
                        //'bank_transfer' => 'Bank Transfer',
                    ])
                    ->label('Payment Method'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListImportTransactions::route('/'),
            'create' => Pages\CreateImportTransaction::route('/create'),
            'edit' => Pages\EditImportTransaction::route('/{record}/edit'),
        ];
    }
}
