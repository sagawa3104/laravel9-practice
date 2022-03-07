<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryItem extends Pivot
{
    public $incrementing = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
