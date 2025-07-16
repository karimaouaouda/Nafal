<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'quotation_products')
            ->withPivot('quantity', 'price', 'discount', 'sold');
    }

    public function getCodeAttribute(): string
    {
        return sprintf('SQ-NF-%d-%d', $this->getAttribute('created_at')->year, $this->getAttribute('id'));
    }
}
