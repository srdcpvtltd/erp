<?php

namespace App\Http\Controllers\Api;

use App\Models\Farming;
use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Center;
use App\Models\Country;
use App\Models\District;
use App\Models\GramPanchyat;
use App\Models\SeedCategory;
use App\Models\State;
use App\Models\Village;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                        ->where('farmings.created_by',Auth::user()->id)
                        ->orWhere('users.supervisor_id',Auth::user()->id)->get();
            return response([
                "farmings" => $farmings,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request,[
                'name' => 'required',
                'father_name' => 'required',
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
                'zone_id' => 'required',
                'center_id' => 'required',
                'seed_category_id' => 'required',
            ]);
            $zone = Zone::find($request->zone_id);
            $center = Center::find($request->center_id);
            $existingFarmingProfiles = Farming::where('zone_id',$zone->id)->count() + 1;
            $request->merge([
                'g_code' => @$zone->zone_number.'/'.@$center->center_number.'/000'.$existingFarmingProfiles
            ]);
            $farming = Farming::create($request->all());

            return response([
                "farming" => $farming,
                "message" => "Farming Registration Created Successfully.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Farming $farming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farming $farming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
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
            $farming = Farming::find($id);
            $farming->update($request->all());
            return response([
                "farming" => $farming,
                "message" => "Farming Registration Updated Successfully.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $farming = Farming::find($id);
            $farming->delete();

            return response([
                "message" => "Farming Registration Deleted Successfully.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getCountries()
    {
        try {
            $countries = Country::all();
            return response([
                "countries" => $countries
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getStates(Request $request)
    {
        try {
            $this->validate($request,[
                'country_id' => 'required',
            ]);
            $states = State::where('country_id',$request->country_id)->get();
            return response([
                "states" => $states
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getDistricts(Request $request)
    {
        try {
            $this->validate($request,[
                'state_id' => 'required',
            ]);
            $districts = District::where('state_id',$request->state_id)->get();
            return response([
                "districts" => $districts
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getBlocks(Request $request)
    {
        try {
            $this->validate($request,[
                'district_id' => 'required',
            ]);
            $blocks = Block::where('district_id',$request->district_id)->get();
            return response([
                "blocks" => $blocks
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getGramPanchyats(Request $request)
    {
        try {
            $this->validate($request,[
                'block_id' => 'required',
            ]);
            $gram_panchyats = GramPanchyat::where('block_id',$request->block_id)->get();
            return response([
                "gram_panchyats" => $gram_panchyats
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getVillages(Request $request)
    {
        try {
            $this->validate($request,[
                'gram_panchyat_id' => 'required',
            ]);
            $villages = Village::where('gram_panchyat_id',$request->gram_panchyat_id)->get();
            return response([
                "villages" => $villages
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getZones()
    {
        try {
            $zones = Zone::all();
            return response([
                "zones" => $zones
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getSeedCategories()
    {
        try {
            $seed_categories = SeedCategory::all();
            return response([
                "seed_categories" => $seed_categories
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getCenter(Request $request)
    {
        try {
            $this->validate($request,[
                'zone_id' => 'required',
            ]);
            $centers = Center::where('zone_id',$request->zone_id)->get();
            return response([
                "centers" => $centers
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
