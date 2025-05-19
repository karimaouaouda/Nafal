<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasTranslations;

    public array $translatable = ['value'];
    protected $fillable = [
        'key',
        'value',
    ];

    protected $guarded = ['id'];


}
