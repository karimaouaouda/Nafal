<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    /** @use HasFactory<\Database\Factories\ReceiptFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
    ];


    public function transaction(): BelongsTo{
        return $this->belongsTo(Transaction::class);
    }
}
