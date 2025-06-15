<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class SubRegion extends Model
{
    protected $fillable = [
        'name',
        'region_id',
        'translations',
        'flag',
        'wikiDataId'
    ];


    protected $casts = [
        'translations' => 'array',
    ];

    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
