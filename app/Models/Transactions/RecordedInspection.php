<?php

namespace App\Models\Transactions;

use App\Models\Masters\Phase;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RecordedInspection extends Pivot
{
    public $incrementing = true;

    protected $table = 'recorded_inspections';

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function recordedProduct()
    {
        return $this->belongsTo(RecordedProduct::class);
    }
}
