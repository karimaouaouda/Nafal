<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'name',
        'translations',
        'flag',
        'wikiDataId'
    ];


    protected $casts = [
        'translations' => 'array',
    ];

    public function subRegions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
