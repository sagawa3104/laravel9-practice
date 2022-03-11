<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecificationRequest;
use App\Http\Requests\UpdateSpecificationRequest;
use App\Models\Masters\Specification;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specifications = Specification::paginate(15);

        return view('specifications.index', [
            'specifications' => $specifications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSpecificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecificationRequest $request)
    {
        $input = $request->all();
        Specification::create($input);

        return redirect(route('specifications.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Masters\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function show(Specification $specification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Masters\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function edit(Specification $specification)
    {
        return view('specifications.edit', [
            'specification' => $specification
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSpecificationRequest  $request
     * @param  \App\Models\Masters\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecificationRequest $request, Specification $specification)
    {
        $input = $request->all();

        $specification->update($input);
        $specification->save();

        return redirect(route('specifications.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Masters\Specification  $specification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specification $specification)
    {
        $specification->delete();

        return redirect(route('specifications.index'));
    }
}
