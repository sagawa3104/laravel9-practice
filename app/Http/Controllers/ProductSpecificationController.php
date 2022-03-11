<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplySpecificationsForProductRequest;
use App\Models\Masters\Product;
use App\Models\Masters\Specification;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    /**
     *
     *
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function attachSpecifications(Product $product)
    {
        $specifications = Specification::all();
        return view('products.attach-specifications', [
            'product'=> $product,
            'specifications'=> $specifications,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplySpecificationsForProductRequest  $request
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function applySpecifications(ApplySpecificationsForProductRequest $request, Product $product)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $product->specifications()->sync(Specification::all()->pluck('id'));
        // specificationsが含まれていないなら、既存の関連を全解除
        }else if(isset($input['specifications']) && !isset($input['all']['release']) ){
            $product->specifications()->sync($input['specifications']);
        }else{
            $product->specifications()->detach();
        }

        // return $input;
        return redirect(route('products.index'));
    }
}
