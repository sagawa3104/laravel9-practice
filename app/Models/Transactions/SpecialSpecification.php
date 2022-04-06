<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialSpecification extends Model
{
    use HasFactory;

    public function recordedProduct()
    {
        return $this->belongsTo(RecordedProduct::class);
    }
}
