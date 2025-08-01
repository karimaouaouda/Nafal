<?php

namespace App\Traits;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Model
 */
trait HasContact
{



    /**
     * @return MorphOne
    */
    public function contact(): MorphOne
    {
        return $this->morphOne(\App\Models\Contact::class, 'contactable');
    }

    public function delete(): ?bool
    {
        $this->contact()?->delete();
        $this->address()?->delete();
        return parent::delete();
    }
}
