<?php

namespace App\Models\Transactions;

use App\Models\Masters\Item;
use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedInspectionDetailMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'item_id',
        'x_point',
        'y_point',
    ];

    public function recordedInspectionDetail()
    {
        return $this->belongsTo(RecordedInspectionDetail::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
