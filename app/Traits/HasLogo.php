<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Model
*/
trait HasLogo
{
    public string $logo_api_endpoint_format = "https://ui-avatars.com/api/?background=random&name=%s";
    protected static string $logo_col_name = 'logo_path';
    public function getLogoUrlAttribute(): string
    {
        return $this->getAttribute(static::$logo_col_name) ?
            Storage::url($this->getAttribute(static::$logo_col_name)) :
            sprintf($this->logo_api_endpoint_format, $this->getAttribute('latin_name'));
    }
}
