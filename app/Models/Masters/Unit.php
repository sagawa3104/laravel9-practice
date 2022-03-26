<?php

namespace App\Models\Masters;

use App\Models\Transactions\RecordedInspectionDetailMapping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'x_length',
        'y_length',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['id'])->using(ProductUnit::class);
    }

    public function recordedInspectionDetailMappings()
    {
        return $this->hasMany(RecordedInspectionDetailMapping::class);
    }
}
