<?php

namespace App\Http\Controllers\Farming;

use App\Models\Guarantor;
use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Country;
use App\Models\District;
use App\Models\Farming;
use App\Models\GramPanchyat;
use App\Models\State;
use App\Models\Village;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuarantorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guarantors = Guarantor::where('created_by',Auth::user()->id)->get();
        return view('farmer.guarantor.index',compact('guarantors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.is_validate',1)
                    ->where('farmings.created_by',Auth::user()->id)
                    ->orWhere('users.supervisor_id',Auth::user()->id)
                    ->get();
        $countries = Country::all();
        return view('farmer.guarantor.create',compact('countries','farmings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try{
            $this->validate($request,[
                'name' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
                'district_id' => 'required',
                'block_id' => 'required',
                'gram_panchyat_id' => 'required',
                'village_id' => 'required',
                'age' => 'required',
                'created_by' => 'required',
            ]);
            Guarantor::create($request->all());
            return redirect()->to(route('farmer.guarantor.index'))->with('success', 'Guarantor Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $guarantor = Guarantor::find($id);
        $countries = Country::all();
        $states = State::where('country_id',$guarantor->country_id)->get();
        $districts = District::where('state_id',$guarantor->state_id)->get();
        $blocks = Block::where('district_id',$guarantor->district_id)->get();
        $gram_panchyats = GramPanchyat::where('block_id',$guarantor->block_id)->get();
        $villages = Village::where('gram_panchyat_id',$guarantor->gram_panchyat_id)->get();
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.is_validate',1)
                    ->where('farmings.created_by',Auth::user()->id)
                    ->orWhere('users.supervisor_id',Auth::user()->id)
                    ->get();
        return view('farmer.guarantor.edit', compact(
            'guarantor',
            'countries',
            'states',
            'districts',
            'blocks',
            'gram_panchyats',
            'villages',
            'farmings',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $guarantor = Guarantor::find($id);
        $guarantor->update($request->all());
        return redirect()->back()->with('success', 'Guarantor Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guarantor = Guarantor::find($id);
        $guarantor->delete();
        return redirect()->back()->with('success', 'Guarantor Deleted Successfully.');
    }
}
