<?php

namespace App\Http\Controllers\Farming;

use App\Models\Farming;
use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Country;
use App\Models\District;
use App\Models\FarmerLoan;
use App\Models\FarmingPayment;
use App\Models\GramPanchyat;
use App\Models\Guarantor;
use App\Models\State;
use App\Models\Village;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.created_by',Auth::user()->id)
                    ->orWhere('users.supervisor_id',Auth::user()->id)->get();
        return view('farmer.registration.index',compact('farmings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('farmer.registration.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name' => 'required',
                'mobile' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
                'district_id' => 'required',
                'block_id' => 'required',
                'gram_panchyat_id' => 'required',
                'village_id' => 'required',
                'age' => 'required',
                'gender' => 'required',
                'qualification' => 'required',
                'land_holding' => 'required',
                'language' => 'required',
                'sms_mode' => 'required',
                'created_by' => 'required',
            ]);
            Farming::create($request->all());
            return redirect()->to(route('farmer.farming_registration.index'))->with('success', 'Farming Added Successfully.');
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
        $farming = Farming::find($id);
        $guarantors = Guarantor::where('farming_id',$farming->id)->get();
        $security_deposits = FarmingPayment::where('farming_id',$farming->id)
                    ->whereIn('type',[FarmingPayment::SECURITY_DEPOSIT,FarmingPayment::REIMBURSEMENT])->get();
        $bank_guarantees = FarmingPayment::where('farming_id',$farming->id)
                    ->where('type',FarmingPayment::BANK_GUARANTEE)->get();
        $loans = FarmerLoan::where('farming_id',$farming->id)->get();
        return view('farmer.registration.show',compact('farming','guarantors','security_deposits','bank_guarantees','loans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $farming = Farming::find($id);
        $countries = Country::all();
        $states = State::where('country_id',$farming->country_id)->get();
        $districts = District::where('state_id',$farming->state_id)->get();
        $blocks = Block::where('district_id',$farming->district_id)->get();
        $gram_panchyats = GramPanchyat::where('block_id',$farming->block_id)->get();
        $villages = Village::where('gram_panchyat_id',$farming->gram_panchyat_id)->get();
        return view('farmer.registration.edit', compact(
            'farming',
            'countries',
            'states',
            'districts',
            'blocks',
            'gram_panchyats',
            'villages',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $farming = Farming::find($id);
        $farming->update($request->all());
        return redirect()->back()->with('success', 'Farming Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $farming = Farming::find($id);
        $farming->delete();
        return redirect()->back()->with('success', 'Farming Deleted Successfully.');
    }
    public function getStates(Request $request)
    {
        $states = State::where('country_id',$request->country_id)->get();
        return response()->json([
            'states' => $states,
        ]);
    }
    public function getDistricts(Request $request)
    {
        $districts = District::where('state_id',$request->state_id)->get();
        return response()->json([
            'districts' => $districts,
        ]);
    }
    public function getBlocks(Request $request)
    {
        $blocks = Block::where('district_id',$request->district_id)->get();
        return response()->json([
            'blocks' => $blocks,
        ]);
    }
    public function getGramPanchyats(Request $request)
    {
        $gram_panchyats = GramPanchyat::where('block_id',$request->block_id)->get();
        return response()->json([
            'gram_panchyats' => $gram_panchyats,
        ]);
    }
    public function getVillages(Request $request)
    {
        $villages = Village::where('gram_panchyat_id',$request->gram_panchyat_id)->get();
        return response()->json([
            'villages' => $villages,
        ]);
    }

    public function validateProfile($id)
    {
        $farming = Farming::find($id);
        $farming->update(['is_validate'=>1,'farmer_id'=>'ERP-'.random_int(100000, 999999)]);
        return redirect()->to(route('farmer.farming_registration.index'))->with('success', 'Farming Registration Validated Successfully.');

    }

}
