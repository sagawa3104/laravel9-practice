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
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot(['id'])->using(CategoryItem::class);
    }

    public function inspections()
    {
        return $this->belongsToMany(Inspection::class, null, null, 'inspection_id')->withPivot(['id'])->using(CategoryInspection::class);
    }
}
