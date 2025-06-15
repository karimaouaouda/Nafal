<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso3',
        'iso2',
        'numeric_code',
        'phonecode',
        'capital',
        'currency',
        'currency_symbol',
        'currency_name',
        'tld',
        'native',
        'region',
        'region_id',
        'subregion',
        'subregion_id',
        'nationality',
        'timezones',
        'translations',
        'latitude',
        'longitude',
        'emoji',
        'emojiU',
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

    public function subregion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subregion::class);
    }

    public function states(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return  $this->hasMany(State::class);
    }

    public function getFullNameAttribute(): string
    {
        $translations = $this->getAttribute('translations');
        if (empty($translations)) {
            return $this->getAttribute('name');
        }
        if( !is_array($translations) ){
            $translations = json_decode($translations, true);
        }
        $arabic_name = $translations['fa'] ?? "غير معرف";
        $english_name = $this->getAttribute('name');

        return sprintf("%s - %s", $english_name, $arabic_name);

    }
}
