<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'form',
        'is_by_recorded_product',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot(['id'])->using(CategoryItem::class);
    }

    public function phases()
    {
        return $this->belongsToMany(Phase::class)->withPivot(['id'])->using(CategoryPhase::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class)->withPivot(['id'])->using(CategorySpecification::class);
    }
}
