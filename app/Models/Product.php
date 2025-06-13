<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'unity_id',
        'sku',
        'title',
        'description',
        'image',
        'sheets',
        'remark',
    ];

    protected $casts = [
        'sheets' => 'array',
    ];

    public static function getSheetsDir(): string
    {
        return 'products/sheets';
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'transaction_products');
    }

    public function importTransactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ImportTransaction::class);
    }
    public function unity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unity::class);
    }
}
