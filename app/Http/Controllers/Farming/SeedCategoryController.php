<?php

namespace App\Http\Controllers\Farming;

use App\Models\SeedCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class SeedCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seed_categories = SeedCategory::all();
        return view('farmer.seed_category.index',compact('seed_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('farmer.seed_category.create');
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
            SeedCategory::create($request->all());
            return redirect()->back()->with('success', 'Seed Category Added Successfully.');
        }catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SeedCategory $seedCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeedCategory $seedCategory)
    {
        return view('farmer.seed_category.edit', compact('seedCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $seedCategory = SeedCategory::find($id);
        $seedCategory->update($request->all());
        return redirect()->back()->with('success', 'Seed Category Updated Successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $seedCategory = SeedCategory::find($id);
        $seedCategory->delete();
        return redirect()->back()->with('success', 'Seed Category Deleted Successfully.');
    }
}
