<?php

namespace App\Models\Masters;

use App\Models\Transactions\RecordedInspection;
use App\Models\Transactions\RecordedProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot(['id'])->using(CategoryPhase::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inspections')->withPivot(['id'])->as('inspection')->using(Inspection::class);
    }

    public function recordedProducts()
    {
        return $this->belongsToMany(RecordedProduct::class, 'recorded_inspections')->as('recordedInspection')->withPivot(['id'])->using(RecordedInspection::class);
    }
}
