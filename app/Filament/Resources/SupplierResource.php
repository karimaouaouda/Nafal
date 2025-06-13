<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Customer;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'persons';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('client personal informations')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('latin_name')
                                ->placeholder('customer latin name')
                                ->maxWidth('xl')
                                ->columnSpan(1)
                                ->required()
                                ->prefixIcon('heroicon-o-user')
                                ->autocapitalize()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('arabic_name')
                                ->placeholder('customer arabic name')
                                ->maxWidth('xl')
                                ->prefixIcon('heroicon-o-user')
                                ->columnSpan(1)
                                ->nullable()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('customer_number')
                                ->placeholder('Customer number')
                                ->prefixIcon('heroicon-o-identification')
                                ->maxWidth('xl')
                                ->columnSpan(1)
                                ->required()
                                ->integer(),
                            Forms\Components\TextInput::make('vat_number')
                                ->placeholder('tax number')
                                ->prefixIcon('heroicon-o-identification')
                                ->maxWidth('xl')
                                ->columnSpan(1)
                                ->required()
                                ->integer(),
                        ]),
                    Forms\Components\Wizard\Step::make('client address informations')
                        ->schema([
                            Forms\Components\Select::make('address.country')
                                ->label('Country')
                                ->options([
                                    'SA' => 'Saudi Arabia - السعودية',
                                ])
                                ->default('SA')
                                ->required(),
                            Forms\Components\Select::make('address.province')
                                ->label('Province')
                                ->options([
                                    'riyadh' => 'Riyadh - الرياض'
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('address.city')
                                ->label('City')
                                ->required(),
                            Forms\Components\TextInput::make('address.street_line_1')
                                ->label('Street Line 1')
                                ->required(),
                            Forms\Components\TextInput::make('address.street_line_2')
                                ->label('Street Line 2')
                                ->nullable(),
                            Forms\Components\TextInput::make('address.postal_code')
                                ->label('Postal Code')
                                ->required(),
                        ]),
                    Forms\Components\Wizard\Step::make('client contact informations')
                        ->schema([
                            Forms\Components\TextInput::make('contact.phone_number')
                                ->label('Phone Number')
                                ->nullable()
                                ->unique('contacts', 'phone_number')
                                ->tel(),
                            Forms\Components\TextInput::make('contact.email')
                                ->email()
                                ->unique('contacts', 'email')
                                ->required(),
                            Forms\Components\TextInput::make('contact.website')
                                ->url()
                                ->nullable(),
                        ]),
                    Forms\Components\Wizard\Step::make('client appearance')
                        ->schema([
                            Forms\Components\FileUpload::make('logo_path')
                                ->disk('public')
                                ->directory(Supplier::getLogosBaseDirPath())
                                ->nullable()
                                ->image(),
                        ])
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
