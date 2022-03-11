<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Inspection extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'inspections';

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
