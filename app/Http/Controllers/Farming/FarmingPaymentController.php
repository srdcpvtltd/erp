<?php

namespace App\Http\Controllers\Farming;

use App\Models\Farming;
use App\Models\FarmingPayment;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmingPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = FarmingPayment::where('created_by',Auth::user()->id)->get();
        return view('farmer.payment.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.created_by',Auth::user()->id)
                    ->where('farmings.is_validate',1)
                    ->get();
        return view('farmer.payment.create',compact('farmings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'farming_id' => 'required',
                'amount' => 'required',
                'created_by' => 'required',
            ]);
            FarmingPayment::create($request->all());
            return redirect()->to(route('farmer.payment.index'))->with('success', 'Payment Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmingPayment $farmingPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $payment = FarmingPayment::find($id); 
        $farmings = Farming::query()->select('farmings.*')->join('users','users.id','farmings.created_by')
                    ->where('farmings.created_by',Auth::user()->id)
                    ->where('farmings.is_validate',1)
                    ->get();
        return view('farmer.payment.edit', compact(
            'payment',
            'farmings',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $farmingPayment = FarmingPayment::find($id);
        $farmingPayment->update($request->all());
        return redirect()->back()->with('success', 'Farming Payment Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $farmingPayment = FarmingPayment::find($id);
        $farmingPayment->delete();
        return redirect()->back()->with('success', 'Farming Payment Deleted Successfully.');
    }
}
