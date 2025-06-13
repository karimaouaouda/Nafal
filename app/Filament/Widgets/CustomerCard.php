<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\Widget;

class CustomerCard extends Widget
{
    protected static string $view = 'filament.widgets.customer-card';
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = "full";

    public Customer $customer;
}
