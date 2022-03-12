<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyCategoriesForPhaseRequest;
use App\Models\Masters\Category;
use App\Models\Masters\Phase;
use Illuminate\Http\Request;

class CategoryPhaseController extends Controller
{
    /**
     *
     *
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function attachCategories(Phase $phase)
    {
        $categories = Category::all();
        return view('phases.attach-categories', [
            'phase'=> $phase,
            'categories'=> $categories,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplyCategoriesForPhaseRequest  $request
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function applyCategories(ApplyCategoriesForPhaseRequest $request, Phase $phase)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $phase->categories()->sync(Category::all()->pluck('id'));
        // specificationsが含まれていないなら、既存の関連を全解除
        }else if(isset($input['categories']) && !isset($input['all']['release']) ){
            $phase->categories()->sync($input['categories']);
        }else{
            $phase->categories()->detach();
        }

        // return $input;
        return redirect(route('phases.index'));
    }
}
