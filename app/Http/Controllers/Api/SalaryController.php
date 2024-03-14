<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayslipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    
    public function getPayslipTypes()
    {
        try {
            $payslip_types = PayslipType::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "payslip_types" => $payslip_types,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function updateBasicSalary(Request $request)
    {
        try {
            $this->validate($request,[
                'salary_type' => 'required',
                'salary' => 'required',
                'employee_id' => 'required',
            ]);
            $employee = Employee::findOrFail($request->employee_id);
            $employee->salary_type = $request->salary_type;
            $employee->salary = $request->salary;
            $employee->save();
            return response([
                "employee" => $employee,
                "message" => "Employee Salary Updated.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
