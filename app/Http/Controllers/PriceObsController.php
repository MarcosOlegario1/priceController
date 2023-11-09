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
            'price'        => '',
            'old_price'    => '',
            'mail'         => 'required',
            'updates'      => 'required'
        ]);
        PriceObs::create($data);

        return redirect()->route('objects.index')
                         ->with('success', 'created item successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataObject = PriceObs::findOrFail($id);
        return ["object" => $dataObject];
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
    public function update(Request $request, $id)
    {
        $objects = PriceObs::findOrFail($id);
        $objects->update($request->all());
        
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
    public function destroy($id)
    {
        $object = PriceObs::findOrFail($id);
        $object->delete();

        return response()->noContent();
    }
}