<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AllowanceOption;
use App\Models\Allowance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowanceController extends Controller
{
    
    public function getAllowances()
    {
        try {
            $allowances = Allowance::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "allowances" => $allowances,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }   
    public function getAllowanceOptions()
    {
        try {
            $allowance_options = AllowanceOption::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
            return response([
                "allowance_options" => $allowance_options,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getAllowanceTypes()
    {
        try {
            $types = [
                'fixed' => 'Fixed',
                'percentage' => 'Percentage',
            ];
            return response([
                "types" => $types,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $this->validate($request,[
                'allowance_option' => 'required',
                'title' => 'required',
                'employee_id' => 'required',
                'type' => 'required',
                'amount' => 'required',
            ]);
            $allowance                   = new Allowance();
            $allowance->employee_id      = $request->employee_id;
            $allowance->allowance_option = $request->allowance_option;
            $allowance->title            = $request->title;
            $allowance->type             = $request->type;
            $allowance->amount           = $request->amount;
            $allowance->created_by       = Auth::user()->creatorId();
            $allowance->save();
            return response([
                "allowance" => $allowance,
                "message" => "Employee Allowance Created.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
