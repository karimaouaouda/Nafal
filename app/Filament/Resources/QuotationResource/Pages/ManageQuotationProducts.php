<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageQuotationProducts extends ManageRelatedRecords
{
    protected static string $resource = QuotationResource::class;

    protected static string $relationship = 'products';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Products';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextInputColumn::make('discount')
                    ->updateStateUsing(function(Product $record, $state){
                        $record->pivot->discount = $state;
                        $record->pivot->save();
                    })
                    ->default('0'),
                Tables\Columns\TextInputColumn::make('sold')
                    ->updateStateUsing(function(Product $record, $state){
                        $record->pivot->sold = $state;
                        $record->pivot->save();
                    })
                    ->default('0')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
