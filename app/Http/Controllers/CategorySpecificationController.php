<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplySpecificationsForCategoryRequest;
use App\Models\Masters\Category;
use App\Models\Masters\Specification;
use Illuminate\Http\Request;

class CategorySpecificationController extends Controller
{
    /**
     *
     *
     * @param  \App\Models\Masters\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function attachSpecifications(Category $category)
    {
        $specifications = Specification::all();
        return view('categories.attach-specifications', [
            'category'=> $category,
            'specifications'=> $specifications,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplySpecificationsForCategoryRequest  $request
     * @param  \App\Models\Masters\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function applySpecifications(ApplySpecificationsForCategoryRequest $request, Category $category)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $category->specifications()->sync(Specification::all()->pluck('id'));
        // specificationsが含まれていないなら、既存の関連を全解除
        }else if(isset($input['specifications']) && !isset($input['all']['release']) ){
            $category->specifications()->sync($input['specifications']);
        }else{
            $category->specifications()->detach();
        }

        // return $input;
        return redirect(route('categories.index'));
    }
}
