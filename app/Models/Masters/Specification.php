<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_checking_item',
        'is_mapping_item',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['id'])->using(ProductSpecification::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot(['id'])->using(CategorySpecification::class);
    }

}
