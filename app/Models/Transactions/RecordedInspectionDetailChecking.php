<?php

namespace App\Models\Transactions;

use App\Models\Masters\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedInspectionDetailChecking extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'type'
    ];

    public function recordedInspectionDetail()
    {
        return $this->belongsTo(RecordedInspectionDetail::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
