<?php

namespace App\Models;

use App\Traits\HasAddress;
use App\Traits\HasContact;
use App\Traits\HasLogo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, SoftDeletes, HasAddress, HasContact, HasLogo;

    protected static string $logo_base_dir = 'customers/logos';

    protected $fillable = [
        'customer_number',
        'latin_name',
        'arabic_name',
        'vat_number',
        'email',
        'phone',
        'logo_path'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    public static function getLogosBaseDirPath(){
        return static::$logo_base_dir;
    }
}
