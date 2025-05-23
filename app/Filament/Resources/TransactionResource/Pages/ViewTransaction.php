<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\QuotationResource\Pages\CreateQuotation;
use App\Filament\Resources\TransactionResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ViewTransaction extends ViewRecord implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithInfolists, InteractsWithTable;

    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('customer information')
                ->schema([
                    TextEntry::make('id')
                        ->prefix('#')
                        ->extraAttributes([
                            'class' => 'font-bold',
                        ], true),
                    TextEntry::make('customer.latin_name')
                        ->badge(),
                ])->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextInputColumn::make('discount')
                    ->updateStateUsing(function (Product $record, $state) {
                        $record->pivot->discount = $state;
                        $record->pivot->save();
                    })
                    ->default('0'),
                Tables\Columns\TextInputColumn::make('sold')
                    ->updateStateUsing(function (Product $record, $state) {
                        $record->pivot->sold = $state;
                        $record->pivot->save();
                    })
                    ->default('0'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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

    protected function getHeaderWidgets(): array
    {
        return [
            TransactionResource\Widgets\TransactionProceed::class,
            TransactionResource\Widgets\QuotationDetails::make([
                'page' => $this,
            ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->quotationAction(),
        ];
    }

    protected function getTableQuery(): Builder|Relation|null
    {
        return $this->record->quotation->products()->getQuery();
    }

    public function getFormStatePath(): ?string
    {
        return 'data';
    }

    private function quotationAction(): Actions\Action
    {
        $quotation = $this->record->quotation;

        return is_null($quotation) ?
            Actions\Action::make('new quotation')
                ->icon('heroicon-o-plus')
                ->openUrlInNewTab()
                ->url(
                    CreateQuotation::getUrl([
                        'transaction' => $this->record->getAttribute('id'),
                    ])
                ) :
            Actions\Action::make('view quotation')
                ->color(Color::Gray)
                ->form([
                    TextInput::make('cus_ref')
                        ->default($quotation->getAttribute('cus_ref'))
                        ->readOnly(),
                    Textarea::make('attention')
                        ->default($quotation->getAttribute('attention'))
                        ->readOnly(),
                ])
                ->modalSubmitAction(false)
                ->icon('heroicon-o-eye');
    }
}
