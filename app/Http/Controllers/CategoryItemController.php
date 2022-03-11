<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyItemsForCategoryRequest;
use App\Models\Masters\Category;
use App\Models\Masters\Item;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    /**
     *
     *
     * @param  \App\Models\Masters\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function attachItems(Category $category)
    {
        $items = Item::all();
        return view('categories.attach-items', [
            'category'=> $category,
            'items'=> $items,
        ]);
    }

    /**
     *
     *
     * @param  App\Http\Requests\ApplyItemsForCategoryRequest  $request
     * @param  \App\Models\Masters\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function applyItems(ApplyItemsForCategoryRequest $request, Category $category)
    {
        $input = $request->all();

        if(isset($input['all']['select'])){
            $category->items()->sync(Item::all()->pluck('id'));
        // specificationsが含まれていないなら、既存の関連を全解除
        }else if(isset($input['items']) && !isset($input['all']['release']) ){
            $category->items()->sync($input['items']);
        }else{
            $category->items()->detach();
        }

        // return $input;
        return redirect(route('categories.index'));
    }
}
