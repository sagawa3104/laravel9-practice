<?php

namespace App\Models\Masters;

use App\Models\Transactions\RecordedProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'inspections')->withPivot(['id'])->as('inspection')->using(Inspection::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class)->withPivot(['id'])->using(ProductUnit::class);
    }

    public function recordedProducts()
    {
        return $this->hasMany(RecordedProduct::class);
    }
}
