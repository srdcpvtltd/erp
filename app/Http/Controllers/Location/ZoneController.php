<?php

namespace App\Http\Controllers\Location;

use App\Models\Zone;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::all();
        return view('location.zone.index',compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.zone.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name' => 'required',
            ]);
            Zone::create($request->all());
            return redirect()->back()->with('success', 'Zone Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return view('location.zone.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $zone = Zone::find($id);
        $zone->update($request->all());
        return redirect()->back()->with('success', 'Zone Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $zone = Zone::find($id);
        $zone->delete();
        return redirect()->back()->with('success', 'Zone Deleted Successfully.');
    }
}
