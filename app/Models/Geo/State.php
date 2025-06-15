<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'flips_code',
        'iso2',
        'type',
        'level',
        'parent_id',
        'native',
        'latitude',
        'longitude',
        'flag',
        'wikiDataId'
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }
}
