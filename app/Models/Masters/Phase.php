<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inspections')->withPivot(['id'])->as('inspection')->using(Inspection::class);
    }
}
