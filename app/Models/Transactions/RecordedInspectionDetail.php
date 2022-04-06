<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedInspectionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'inspected_result',
    ];

    public function recordedInspection()
    {
        return $this->belongsTo(RecordedInspection::class);
    }

    public function recordedInspectionDetailMapping()
    {
        return $this->hasOne(RecordedInspectionDetailMapping::class);
    }

    public function recordedInspectionDetailChecking()
    {
        return $this->hasOne(RecordedInspectionDetailChecking::class);
    }
}
