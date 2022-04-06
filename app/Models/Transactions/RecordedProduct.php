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
        'is_created_recorded_inspections',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'recorded_inspections')->as('recordedInspection')->withPivot(['id'])->using(RecordedInspection::class);;
    }

    public function specialSpecifications()
    {
        return $this->hasMany(SpecialSpecification::class);
    }

    /**
     * 検査実績を作成済か否かでフィルタリング
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $isCreatedRecordedInspection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsCreatedRecordedInspections($query, $isCreatedRecordedInspection=true)
    {
        return $query->where('is_created_recorded_inspections', $isCreatedRecordedInspection);
    }

    public function createRecordedInspections()
    {
        $this->phases()->attach( $this->product->phases->pluck('id') );
        $this->is_created_recorded_inspections = true;
    }

    public function reassociate(Product $product){
        // 以前の品目に紐づく検査実績を削除
        $this->phases()->detach();
        $this->is_created_recorded_inspections = false;
        $this->product()->associate($product);
    }


}
