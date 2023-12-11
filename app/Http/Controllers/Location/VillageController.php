<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\GramPanchyat;
use App\Models\Village;
use Exception;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $villages = Village::all();
        return view('location.village.index',compact('villages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gram_panchyats = GramPanchyat::all()->pluck('name', 'id');
        $gram_panchyats->prepend('Select GP', '');
        return view('location.village.create',compact('gram_panchyats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        try{
            $this->validate($request,[
                'name' => 'required',
                'gram_panchyat_id' => 'required',
            ]);
            Village::create($request->all());
            return redirect()->back()->with('success', 'Village Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(Village $village)
    {
        $gram_panchyats = GramPanchyat::all()->pluck('name', 'id');
        $gram_panchyats->prepend('Select GP', '');
        return view('location.village.edit', compact('village','gram_panchyats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $village = Village::find($id);
        $village->update($request->all());
        return redirect()->back()->with('success', 'Village Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $village = Village::find($id);
        $village->delete();
        return redirect()->back()->with('success', 'Village Deleted Successfully.');
    }
}
