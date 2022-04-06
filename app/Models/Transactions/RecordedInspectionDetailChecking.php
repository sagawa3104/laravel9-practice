<?php

namespace App\Models\Transactions;

use App\Models\Masters\Item;
use App\Models\Masters\Specification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedInspectionDetailChecking extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'specification_id',
        'special_specification_id',
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

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }

    public function specialSpecification()
    {
        return $this->belongsTo(SpecialSpecification::class);
    }
}
