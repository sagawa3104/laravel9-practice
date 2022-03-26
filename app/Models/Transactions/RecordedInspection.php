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

    public function recordedInspectionDetails()
    {
        return $this->hasMany(RecordedInspectionDetail::class, 'recorded_inspection_id');
    }

    /**
     * 製番・工程での検索クエリ
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $param
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $param)
    {
        if(isset($param['code'])){
            $query->whereIn('recorded_product_id', RecordedProduct::where('code', $param['code'])->select('recorded_products.id'));
        }
        if(isset($param['phase'])){
            $query->whereIn('phase_id', Phase::where('id', $param['phase'])->select('phases.id'));
        }
        $query->with([
            'phase',
            'recordedProduct',
            'recordedProduct.product'
        ]);
        return $query;
    }
}
