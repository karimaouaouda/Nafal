<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Widgets\CustomerCard;
use App\Models\Transaction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Support\Services\RelationshipJoiner;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class TransactionDetails extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;
    use TransactionResource\Pages\Traits\HasHeaderFunctions;

    protected static string $resource = TransactionResource::class;

    public Transaction $record;

    public bool $hasQuotation = false;

    protected static string $view = 'filament.resources.transaction-resource.pages.transaction-details';


    protected function getHeaderWidgets(): array
    {
        return [
            CustomerCard::make([
                'customer' => $this->record->customer
            ])
        ];
    }


    public function mount(): void
    {
        $this->hasQuotation = $this->record->quotation()->exists();

        $this->heading = "Transaction Details #" . $this->record->getAttribute('id');
    }

    protected function getTableQuery(): Builder|Relation|null
    {
        return $this->record->products();
    }

    public function table(Table $table): Table
    {

        return $table
            ->reorderable("sort")
            ->description('detail transaction')
            ->heading('transaction products')
            ->relationship(fn (): BelongsToMany => $this->record?->products())
            ->inverseRelationship('transactions')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('price')
                    ->label('unit price')
                    ->color(Color::Green)
                    ->icon('heroicon-o-currency-dollar')
                    ->badge(),
                Tables\Columns\TextColumn::make('pivot.quantity')
                    ->label('quantity')
                    ->color(Color::Indigo)
                    ->icon('heroicon-o-circle-stack')
                    ->badge(),
                Tables\Columns\TextColumn::make('discount')
                    ->color(Color::Blue)
                    ->icon('heroicon-o-percent-badge')
                    ->badge()
                    ->default('0'),
                Tables\Columns\TextColumn::make('sold')
                    ->color(Color::Blue)
                    ->icon('heroicon-o-receipt-percent')
                    ->badge()
                    ->default('0'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->action(function (array $arguments, array $data, Form $form, Table $table, Tables\Actions\AttachAction $action): void {
                        /** @var BelongsToMany $relationship */
                        $relationship = Relation::noConstraints(fn () => $table->getRelationship());

                        $relationshipQuery = app(RelationshipJoiner::class)->prepareQueryForNoConstraints($relationship);

                        $isMultiple = is_array($data['recordId']);

                        $record = $relationshipQuery
                            ->{$isMultiple ? 'whereIn' : 'where'}($relationship->getQualifiedRelatedKeyName(), $data['recordId'])
                            ->{$isMultiple ? 'get' : 'first'}();

                        if ($record instanceof Model) {
                            $action->record($record);
                        }

                        $action->process(function () use ($data, $record, $relationship) {
                            if ($record instanceof Model) {
                                $data['sell_price'] = $record->price;
                            }

                            $relationship->attach(
                                $record,
                                Arr::only($data, $relationship->getPivotColumns()),
                            );
                        }, [
                            'relationship' => $relationship,
                        ]);

                        if ($arguments['another'] ?? false) {
                            $action->callAfter();
                            $action->sendSuccessNotification();

                            $action->record(null);

                            $form->fill();

                            $action->halt();
                        }

                        $action->success();
                    }),
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

    protected function getHeaderActions(): array
    {
        $actions = [];

        if ($this->record->quotation()->exists()) {
            $actions[] = $this->getEditQuotationAction();
        }else{
            $actions[] = $this->createQuotationAction();
        }

        return $actions;
    }

    protected function getFooterWidgets(): array
    {
        return [

        ];
    }
}
