<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'street_line_1',
        'street_line_2',
    ];


    public function addressable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function getFullAddressAttribute(): string
    {
        $addressParts = [
            $this->street_line_1,
            $this->street_line_2,
            $this->city?->name,
            $this->state?->name,
            $this->country?->name,
            $this->postal_code,
        ];

        return implode(', ', array_filter($addressParts));
    }
}
