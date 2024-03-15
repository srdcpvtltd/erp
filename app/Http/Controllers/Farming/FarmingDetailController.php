<?php

namespace App\Http\Controllers\Farming;

use App\Models\FarmingDetail;
use App\Http\Controllers\Controller;
use App\Models\Farming;
use App\Models\SeedCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmingDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $farming_details = FarmingDetail::query()->select('farming_details.*')
                    ->join('users','users.id','farming_details.created_by')
                    ->where('farming_details.created_by',Auth::user()->id)
                    ->orWhere('users.supervisor_id',Auth::user()->id)->get();
        return view('farmer.farming_detail.index',compact('farming_details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.created_by',Auth::user()->id)
                    ->orWhere('users.supervisor_id',Auth::user()->id)->get();
        $seed_categories = SeedCategory::all();
        return view('farmer.farming_detail.create',compact('farmings','seed_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'farming_id' => 'required',
                'plot_number' => 'required',
                'kata_number' => 'required',
                'area_in_acar' => 'required',
                'date_of_harvesting' => 'required',
                'quantity' => 'required',
                'seed_category_id' => 'required',
                'tentative_harvest_quantity' => 'required',
                'created_by' => 'required',
            ]);
            FarmingDetail::create($request->all());
            return redirect()->to(route('farmer.farming_detail.index'))->with('success', 'Farming Detail Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmingDetail $farmingDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $farming_detail = FarmingDetail::find($id);
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
        ->where('farmings.created_by',Auth::user()->id)
        ->orWhere('users.supervisor_id',Auth::user()->id)->get();
        $seed_categories = SeedCategory::all();
        return view('farmer.farming_detail.edit',compact('farming_detail','farmings','seed_categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $farming_detail = FarmingDetail::find($id);
        try{
            $this->validate($request,[
                'farming_id' => 'required',
                'plot_number' => 'required',
                'kata_number' => 'required',
                'area_in_acar' => 'required',
                'date_of_harvesting' => 'required',
                'quantity' => 'required',
                'seed_category_id' => 'required',
                'tentative_harvest_quantity' => 'required',
            ]);
            $farming_detail->update($request->all());
            return redirect()->back()->with('success', 'Farming Detail Updated Successfully.'); 
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $farmingDetail = FarmingDetail::find($id);
        $farmingDetail->delete();
        return redirect()->back()->with('success', 'Farming Detail Deleted Successfully.');
    }
    public function getFarmingDetail(Request $request)
    {
        $farming = Farming::find($request->farming_id);
        $blockHtml = $gpHtml = $villageHtml = $zoneHtml = $centerHtml = '';
        if($farming->block)
        {
            $blockHtml = '<option value="'.$farming->block->id.'"selected>'.$farming->block->name.'</option>';
        }
        if($farming->gram_panchyat)
        {
            $gpHtml = '<option value="'.$farming->gram_panchyat->id.'"selected>'.$farming->gram_panchyat->name.'</option>';
        }
        if($farming->village)
        {
            $villageHtml = '<option value="'.$farming->village->id.'"selected>'.$farming->village->name.'</option>';
        }
        if($farming->zone)
        {
            $zoneHtml = '<option value="'.$farming->zone->id.'"selected>'.$farming->zone->name.'</option>';
        }
        if($farming->center)
        {
            $centerHtml = '<option value="'.$farming->center->id.'" selected>'.$farming->center->name.'</option>';
        }
        return response()->json([
            'blockHtml' => $blockHtml,
            'gpHtml' => $gpHtml,
            'villageHtml' => $villageHtml,
            'zoneHtml' => $zoneHtml,
            'centerHtml' => $centerHtml,
        ]);
    }
}
