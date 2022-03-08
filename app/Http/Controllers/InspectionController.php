<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyPhasesForProductRequest;
use App\Models\Masters\Inspection;
use App\Models\Masters\Phase;
use App\Models\Masters\Product;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspections = Inspection::orderBy('phase_id')->orderBy('product_id')->paginate(15);

        return view('inspections.index', [
            'inspections' => $inspections
        ]);
    }

    /**
     *
     *
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function attachPhases(Product $product)
    {
        $phases = Phase::all();
        return view('products.attach-phases', [
            'product'=> $product,
            'phases'=> $phases,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplyPhasesForProductRequest  $request
     * @param  \App\Models\Masters\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function applyPhases(ApplyPhasesForProductRequest $request, Product $product)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $product->phases()->sync(Phase::all()->pluck('id'));
        // phasesが含まれていないなら、既存の関連を全解除
        }else if(isset($input['phases']) && !isset($input['all']['release']) ){
            $product->phases()->sync($input['phases']);
        }else{
            $product->phases()->detach();
        }

        // return $input;
        return redirect(route('products.index'));
    }
}
