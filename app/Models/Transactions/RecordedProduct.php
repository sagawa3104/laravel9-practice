<?php

namespace App\Models\Transactions;

use App\Models\Masters\Phase;
use App\Models\Masters\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'recorded_inspections')->as('recordedInspection')->withPivot(['id'])->using(RecordedInspection::class);;
    }
}
