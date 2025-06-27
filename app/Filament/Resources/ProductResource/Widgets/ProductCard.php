<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class ProductCard extends Widget
{
    protected static string $view = 'filament.resources.product-resource.widgets.product-card';

    public Product $product;

    protected int | string | array $columnSpan = "full";

    protected static bool $isLazy = false;

}
