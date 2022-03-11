<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSpecification extends Pivot
{
    //
    public $incrementing = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
