<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'category_id',
        'title',
        'description',
        'price',
        'quantity',
        'sheet',
        'category',
        'remark',
        'image'
    ];


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function quotations(): BelongsToMany
    {
        return $this->belongsToMany(Quotation::class, 'quotation_products');
    }


}
