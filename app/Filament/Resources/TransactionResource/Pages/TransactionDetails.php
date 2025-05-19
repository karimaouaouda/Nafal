<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class TransactionDetails extends Page implements HasForms, HasTable, HasInfolists
{
    use InteractsWithTable, InteractsWithForms, InteractsWithInfolists;

    protected static string $resource = TransactionResource::class;

    public Transaction $record;

    protected static string $view = 'filament.resources.transaction-resource.pages.transaction-details';

    protected function getTableQuery(): Builder|Relation|null
    {
        return $this->record->quotation->products();
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return  $infolist
            ->record($this->record)
            ->schema([
            Section::make('customer information')
                ->schema([
                    TextEntry::make('id')
                        ->prefix('#')
                        ->extraAttributes([
                            'class' => 'font-bold'
                        ], true),
                    TextEntry::make('customer.latin_name')
                        ->badge()
                ])->columns(2)
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->description('detail transaction')
            ->heading('quotation products')
            ->relationship(fn (): BelongsToMany => $this->record->quotation->products())
            ->inverseRelationship('quotations')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
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
