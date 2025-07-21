<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Customer;
use App\Models\Geo\City;
use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
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
                    Forms\Components\Wizard\Step::make('Supplier personal informations')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('latin_name')
                                ->placeholder('Supplier latin name')
                                ->maxWidth('xl')
                                ->columnSpan(1)
                                ->required()
                                ->prefixIcon('heroicon-o-user')
                                ->autocapitalize()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('arabic_name')
                                ->placeholder('Supplier arabic name')
                                ->maxWidth('xl')
                                ->prefixIcon('heroicon-o-user')
                                ->columnSpan(1)
                                ->nullable()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('vat_number')
                                ->placeholder('tax number')
                                ->prefixIcon('heroicon-o-identification')
                                ->maxWidth('xl')
                                ->columnSpan(1)
                                ->required()
                                ->integer(),
                        ]),
                    Forms\Components\Wizard\Step::make('Supplier address informations')
                        ->schema([
                            Forms\Components\Select::make('address.country_id')
                                ->label('Country')
                                ->options(Country::all()->pluck('full_name', 'id'))
                                ->searchable()
                                ->live()
                                ->required(),
                            Forms\Components\Select::make('address.state_id')
                                ->label('State')
                                ->live()
                                ->options(function (Forms\Get $get){
                                    $country = $get('address.country_id');
                                    if(empty($country)){
                                        return [];
                                    }

                                    return State::query()->where('country_id', $country)->get()->pluck('name', 'id');
                                })
                                ->required(),
                            Forms\Components\Select::make('address.city_id')
                                ->options(function (Forms\Get $get){
                                    $state = $get('address.state_id');
                                    if(empty($state)){
                                        return [];
                                    }

                                    return City::query()->where('state_id', $state)->get()->pluck('name', 'id');
                                })
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
                    Forms\Components\Wizard\Step::make('Supplier contact informations')
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
                    Forms\Components\Wizard\Step::make('Supplier appearance')
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
                Tables\Columns\TextColumn::make('id')
                    ->prefix('#'),
                Tables\Columns\TextColumn::make('latin_name')
                    ->label('Latin Name')
                    ->searchable()
                    ->tooltip(fn ($state) => $state)
                    ->words(3),
                Tables\Columns\TextColumn::make('arabic_name')
                    ->label('Arabic Name')
                    ->searchable()
                    ->tooltip(fn ($state) => $state)
                    ->words(3)
                    ->extraAttributes([
                        'dir' => 'rtl',
                    ]),
                Tables\Columns\TextColumn::make('vat_number')
                    ->label('VAT Number')
                    ->badge()
                    ->color(Color::Blue),
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
