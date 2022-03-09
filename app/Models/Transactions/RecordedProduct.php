<?php

namespace App\Models\Transactions;

use App\Models\Masters\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
