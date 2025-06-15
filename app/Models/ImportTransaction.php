<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ImportTransaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'buy_price',
        'quantity',
        'payment_method',
        'delivery_type',
        'delivery_price',
        'sold',
        'discount'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getTotalAttribute(): float|int
    {
        return $this->getAttribute('buy_price') * $this->getAttribute('quantity');
    }
}
