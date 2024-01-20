<?php

namespace App\Http\Controllers\Location;

use App\Models\Center;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::all();
        return view('location.center.index',compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all()->pluck('name', 'id');
        $zones->prepend('Select Zone', '');
        return view('location.center.create',compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name' => 'required',
                'zone_id' => 'required',
            ]);
            Center::create($request->all());
            return redirect()->back()->with('success', 'Center Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        $zones = Zone::all()->pluck('name', 'id');
        $zones->prepend('Select Zone', '');
        return view('location.center.edit', compact('center','zones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $center = Center::find($id);
        $center->update($request->all());
        return redirect()->back()->with('success', 'Center Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $center = Center::find($id);
        $center->delete();
        return redirect()->back()->with('success', 'Center Deleted Successfully.');
    }
}
