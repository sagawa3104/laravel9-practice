<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUnit extends Pivot
{
    public $incrementing = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
