<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\View;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_number')
                    ->placeholder('Customer number')
                    ->prefixIcon('heroicon-o-identification')
                    ->maxWidth('xl')
                    ->columnSpan(2)
                    ->required()
                    ->integer(),
                Forms\Components\TextInput::make('latin_name')
                    ->placeholder('customer latin name')
                    ->maxWidth('xl')
                    ->columnSpan(2)
                    ->required()
                    ->prefixIcon('heroicon-o-user')
                    ->autocapitalize()
                    ->maxLength(255),
                Forms\Components\TextInput::make('arabic_name')
                    ->placeholder('customer arabic name')
                    ->maxWidth('xl')
                    ->prefixIcon('heroicon-o-user')
                    ->columnSpan(2)
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('vat_number')
                    ->placeholder('tax number')
                    ->prefixIcon('heroicon-o-identification')
                    ->maxWidth('xl')
                    ->columnSpan(2)
                    ->required()
                    ->integer(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->prefix('#'),
                Tables\Columns\TextColumn::make('latin_name')
                    ->label('Latin Name')
                    ->searchable()
                    ->tooltip(fn($state) => $state)
                    ->words(3),
                Tables\Columns\TextColumn::make('arabic_name')
                    ->label('Arabic Name')
                    ->searchable()
                    ->tooltip(fn($state) => $state)
                    ->words(3)
                    ->extraAttributes([
                        'dir' => 'rtl'
                    ]),
                Tables\Columns\TextColumn::make('vat_number')
                    ->label('VAT Number')
                    ->badge()
                    ->color(Color::Blue)

            ])
            ->filters([
                //
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
