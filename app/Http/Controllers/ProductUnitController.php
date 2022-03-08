<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyUnitsForProductRequest;
use App\Models\Masters\Product;
use App\Models\Masters\Unit;

class ProductUnitController extends Controller
{

    /**
     *
     *
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function attachUnits(Product $product)
    {
        $units = Unit::all();
        return view('products.attach-units', [
            'product'=> $product,
            'units'=> $units,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplyUnitsForProductRequest  $request
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function applyUnits(ApplyUnitsForProductRequest $request, Product $product)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $product->units()->sync(Unit::all()->pluck('id'));
        // unitsが含まれていないなら、既存の関連を全解除
        }else if(isset($input['units']) && !isset($input['all']['release']) ){
            $product->units()->sync($input['units']);
        }else{
            $product->units()->detach();
        }

        // return $input;
        return redirect(route('products.index'));
    }
}
