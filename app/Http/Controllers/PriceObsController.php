<?php

namespace App\Http\Controllers;

use App\Models\PriceObs;
use Illuminate\Http\Request;

class PriceObsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = PriceObs::latest()->paginate(15);

        return response()->json($objects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'description'  => '',
            'url'          => 'required',
            'reference'    => 'required',
            'reference_id' => 'required',
            'price'        => 'required',
            'old_price'    => '',
            'mail'         => 'required'
        ]);

        PriceObs::create($data);

        return redirect()->route('prices.index')
                         ->with('success', 'created item successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PriceObs $price)
    {
        return view('objects.show', compact('objects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceObs $objects)
    {
        return view('objects.edit', compact('objects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PriceObs $price)
    {
        $request->validate([
            'description'  => 'required',
            'url'          => 'required',
            'reference'    => 'required',
            'reference_id' => 'required',
            'price'        => 'required',
            'old_price'    => '',
            'mail'         => 'required'
        ]);

        $objects->update($request->validated());

        return redirect()
                         ->route('objects.index')
                         ->with('success', 'Object updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceObs $price)
    {
        $price->delete();

        return response()->noContent();
    }
}
