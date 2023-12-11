<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\GramPanchyat;
use Exception;
use Illuminate\Http\Request;

class GramPanchyatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gram_panchyats = GramPanchyat::all();
        return view('location.gram_panchyat.index',compact('gram_panchyats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blocks = Block::all()->pluck('name', 'id');
        $blocks->prepend('Select Block', '');
        return view('location.gram_panchyat.create',compact('blocks'));
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
                'block_id' => 'required',
            ]);
            GramPanchyat::create($request->all());
            return redirect()->back()->with('success', 'Gram Panchyat Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GramPanchyat  $gramPanchyat
     * @return \Illuminate\Http\Response
     */
    public function show(GramPanchyat $gramPanchyat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GramPanchyat  $gramPanchyat
     * @return \Illuminate\Http\Response
     */
    public function edit(GramPanchyat $gramPanchyat)
    {
        $blocks = Block::all()->pluck('name', 'id');
        $blocks->prepend('Select Block', '');
        return view('location.gram_panchyat.edit', compact('gramPanchyat','blocks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GramPanchyat  $gramPanchyat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $gramPanchyat = GramPanchyat::find($id);
        $gramPanchyat->update($request->all());
        return redirect()->back()->with('success', 'Gram Panchyat Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GramPanchyat  $gramPanchyat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gramPanchyat = GramPanchyat::find($id);
        $gramPanchyat->delete();
        return redirect()->back()->with('success', 'Gram Panchyat Deleted Successfully.');
    }
}
