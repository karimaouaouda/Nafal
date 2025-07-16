<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnityResource\Pages;
use App\Filament\Resources\UnityResource\RelationManagers;
use App\Models\Unity;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnityResource extends Resource
{
    protected static ?string $model = Unity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'products';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->minLength(3),
                TextInput::make('code')
                    ->required()
                    ->maxLength(3),
                TextInput::make('abbreviation')
                    ->maxLength(3)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->prefix('#')
                    ->badge(),
                TextColumn::make('name')
                    ->label('Unity Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('CODE')
                    ->badge(),
                TextColumn::make('abbreviation')
                    ->label('SHORT NAME')
                    ->badge()
                    ->color(Color::Blue)
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
            'index' => Pages\ListUnities::route('/'),
            'create' => Pages\CreateUnity::route('/create'),
            'edit' => Pages\EditUnity::route('/{record}/edit'),
        ];
    }
}
