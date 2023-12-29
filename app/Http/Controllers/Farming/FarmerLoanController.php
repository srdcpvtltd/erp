<?php

namespace App\Http\Controllers\Farming;

use App\Models\FarmerLoan;
use App\Http\Controllers\Controller;
use App\Models\Farming;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = FarmerLoan::where('created_by',Auth::user()->id)->get();
        return view('farmer.loan.index',compact('loans'));
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
        $categories = ProductServiceCategory::where('created_by',Auth::user()->id)->get();
        return view('farmer.loan.create',compact('categories','farmings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'farming_id' => 'required',
                // 'amount' => 'required',
                'created_by' => 'required',
            ]);
            $farmerLoan = FarmerLoan::create($request->all());
            return redirect()->to(route('farmer.loan.index'))->with('success', 'Loan Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmerLoan $farmerLoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loan = FarmerLoan::find($id); 
        $categories = ProductServiceCategory::where('created_by',Auth::user()->id)->get();
        $types = ProductService::where('category_id',$loan->loan_type_id)->get();
        return view('farmer.loan.edit', compact(
            'loan',
            'categories',
            'types',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $loan = FarmerLoan::find($id);
        $loan->update($request->all());
        return redirect()->back()->with('success', 'Farming Loan Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $loan = FarmerLoan::find($id);
        $loan->delete();
        return redirect()->back()->with('success', 'Farming Loan Deleted Successfully.');
    }
    public function getProductServiceByCategory(Request $request)
    {
        $product_services = ProductService::where('category_id',$request->loan_category_id)->get();
        return response()->json([
            'product_services' => $product_services,
        ]);
    }
    public function getProductServiceDetail(Request $request)
    {
        $product_service = ProductService::find($request->loan_type_id);
        $quantity = $product_service->getTotalProductQuantity() 
                    && $product_service->getTotalProductQuantity() > 0 ? $product_service->getTotalProductQuantity() : 0;
        return response()->json([
            'quantity' => $quantity,
            'product_service' => $product_service,
        ]);
    }
    public function getFarmingDetail(Request $request)
    {
        $farming = Farming::find($request->farming_id);
        return response()->json([
            'farming' => $farming
        ]);
    }
}
