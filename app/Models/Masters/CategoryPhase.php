<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryPhase extends Pivot
{
    public $incrementing = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}
