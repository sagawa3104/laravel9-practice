<?php

namespace App\Models\Masters;

use App\Models\Transactions\RecordedInspectionDetailChecking;
use App\Models\Transactions\RecordedInspectionDetailMapping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_checking_item',
        'is_mapping_item',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot(['id'])->using(CategoryItem::class);
    }

    public function recordedInspectionDetailMappings()
    {
        return $this->hasMany(RecordedInspectionDetailMapping::class);
    }

    public function recordedInspectionDetailCheckings()
    {
        return $this->hasMany(RecordedInspectionDetailChecking::class);
    }
}
