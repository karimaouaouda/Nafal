<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use Filament\Widgets\Widget;

class TransactionProceed extends Widget
{
    protected int|string|array $columnSpan = 2;

    protected static bool $isLazy = false;

    public ?string $name = 'some name';

    protected static string $view = 'filament.resources.transaction-resource.widgets.transaction-proceed';
}
