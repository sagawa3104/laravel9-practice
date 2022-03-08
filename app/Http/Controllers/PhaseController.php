<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Masters\Phase;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phases = Phase::paginate(15);

        return view('phases.index', [
            'phases' => $phases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('phases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhaseRequest $request)
    {
        $input = $request->all();
        Phase::create($input);

        return redirect(route('phases.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phase $phase)
    {
        return view('phases.edit', [
            'phase' => $phase
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhaseRequest  $request
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        $input = $request->all();

        $phase->update($input);
        $phase->save();

        return redirect(route('phases.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Masters\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phase $phase)
    {
        $phase->delete();

        return redirect(route('phases.index'));
    }
}
