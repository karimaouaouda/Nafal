<?php

namespace App\Models;

use App\Traits\HasAddress;
use App\Traits\HasContact;
use App\Traits\HasLogo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory, HasAddress, HasContact, HasLogo;

    protected $fillable = [
        'latin_name',
        'arabic_name',
        'logo_path',
    ];

    public function getNameAttribute(): string
    {
        return $this->getAttribute('latin_name') . ( $this->getAttribute('arabic_name') ? ' - ' . $this->getAttribute('arabic_name') : '');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function importTransactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ImportTransaction::class);
    }

    public static function getLogosBaseDirPath(): string
    {
        return 'suppliers/logos';
    }
}
