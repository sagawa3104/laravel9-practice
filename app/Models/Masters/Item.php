<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot(['id'])->using(CategoryItem::class);
    }
}
