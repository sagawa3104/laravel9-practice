<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategorySpecification extends Pivot
{
    public $incrementing = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
