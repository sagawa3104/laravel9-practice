<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryInspection extends Pivot
{
    public $incrementing = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
