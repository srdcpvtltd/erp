<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            if(Auth::user()->can('manage employee'))
            {
                if(Auth::user()->type == 'Employee')
                {
                    $employees = Employee::where('user_id', '=', Auth::user()->id)->with(['branch','department','designation','documents','salaryType'])->get();
                }
                else
                {
                    $employees = Employee::where('created_by', Auth::user()->creatorId())->with(['branch','department','designation','documents','salaryType'])->get();
                }
                return response([
                    "employees" => $employees,
                ], 200);
            }
            else
            {
                return response([
                    "error" => 'Permission denied.'
                ], 500);
            }
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
                'name' => 'required',
                'dob' => 'required',
                // 'gender' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'department_id' => 'required',
                'designation_id' => 'required',
                // 'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
            ]);
            $objUser        = User::find(Auth::user()->creatorId());
            $total_employee = $objUser->countEmployees();

            $user = User::create(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    // 'gender'=>$request['gender'],
                    'password' => Hash::make($request['password']),
                    'type' => 'employee',
                    'lang' => 'en',
                    'created_by' => Auth::user()->creatorId(),
                ]
            );
            $user->save();
            $user->assignRole('Employee');


            if(!empty($request->document) && !is_null($request->document))
            {
                $document_implode = implode(',', array_keys($request->document));
            }
            else
            {
                $document_implode = null;
            }
            $employee = Employee::create(
                [
                    'user_id' => $user->id,
                    'name' => $request['name'],
                    'dob' => $request['dob'],
                    'gender' => $request['gender'],
                    'phone' => $request['phone'],
                    'address' => $request['address'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'employee_id' => $this->getEmployeeNumber(),
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'designation_id' => $request['designation_id'],
                    'company_doj' => $request['company_doj'],
                    'documents' => $document_implode,
                    'account_holder_name' => $request['account_holder_name'],
                    'account_number' => $request['account_number'],
                    'bank_name' => $request['bank_name'],
                    'bank_identifier_code' => $request['bank_identifier_code'],
                    'branch_location' => $request['branch_location'],
                    'tax_payer_id' => $request['tax_payer_id'],
                    'created_by' => Auth::user()->creatorId(),
                ]
            );

            if($request->hasFile('document'))
            {
                foreach($request->document as $key => $document)
                {

                    $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir             = storage_path('uploads/document/');
                    $image_path      = $dir . $filenameWithExt;

                    if(File::exists($image_path))
                    {
                        File::delete($image_path);
                    }

                    if(!file_exists($dir))
                    {
                        mkdir($dir, 0777, true);
                    }
                    $path              = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                    $employee_document = EmployeeDocument::create(
                        [
                            'employee_id' => $employee['employee_id'],
                            'document_id' => $key,
                            'document_value' => $fileNameToStore,
                            'created_by' => Auth::user()->creatorId(),
                        ]
                    );
                    $employee_document->save();

                }

            }

            $setings = Utility::settings();

            if($setings['new_user'] == 1)
            {
                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];

                $resp = Utility::sendEmailTemplate('new_user', [$user->id => $user->email], $userArr);
                $error = "";
                if(!empty($resp) && $resp['is_success'] == false && !empty($resp['error']))
                {
                    $error = $resp['error'];
                }

                return response([
                    "employee" => $employee,
                    "user" => $user,
                    "error" => $error,
                    "message" => "Employee  successfully created.",
                ], 200);
            }
            return response([
                "employee" => $employee,
                "user" => $user,
                "message" => "Employee  successfully created.",
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getEmployee($id)
    {
        try {
            $employee     = Employee::find($id);
            return response([
                "employee" => $employee,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getDocuments()
    {
        try {
            $documents = Document::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "documents" => $documents,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getBranches()
    {
        try {
            $branches = Branch::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "branches" => $branches,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getDepartments()
    {
        try {
            $departments = Department::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "departments" => $departments,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getDesignations()
    {
        try {
            $designations = Designation::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "designations" => $designations,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getEmployees()
    {
        try {
            $employees  = User::where('created_by', Auth::user()->creatorId())->get();
            return response([
                "employees" => $employees,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getEmployeeID()
    {
        try {            
            return response([
                "employee_id" => $this->getEmployeeNumber(),
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    } 
    public function destroy($id)
    {
        try {  
            if(Auth::user()->can('delete employee'))
            {
                $employee      = Employee::findOrFail($id);
                $user          = User::where('id',$employee->user_id)->first();
                $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
                
                $employee->delete();
                if($user)
                    $user->delete();
                $dir = storage_path('uploads/document/');
                foreach($emp_documents as $emp_document)
                {
                    $emp_document->delete();
                    if(!empty($emp_document->document_value))
                    {
                        unlink($dir . $emp_document->document_value);
                    }
                }
                return response([
                    "success" => true,
                    "message" => "Employee successfully deleted.",
                ], 200);
            }
            else
            {
                return response([
                    "error" => "Permission denied."
                ], 500);
            }     
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }

    }
    public function update(Request $request)
    {
        try {  
            if(Auth::user()->can('edit employee'))
            {
                $this->validate($request,[
                    'employee_id' => 'required',
                    'name' => 'required',
                    'dob' => 'required',
                    'gender' => 'required',
                    'phone' => 'required|numeric',
                    'address' => 'required',
                ]);
                $employee = Employee::findOrFail($request->employee_id);
                if($request->document)
                {
                    foreach($request->document as $key => $document)
                    {
                        if(!empty($document))
                        {
                            $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                            $dir             = 'uploads/document/';
                            $image_path = $dir . $filenameWithExt;

                            if(File::exists($image_path))
                            {
                                File::delete($image_path);
                            }
                            $path = Utility::upload_coustom_file($request,'document',$fileNameToStore,$dir,$key,[]);

                            if($path['flag'] == 1){
                                $url = $path['url'];
                            }else{
                                return response([
                                    "error" => $path['msg']
                                ], 500);
                            }

                            $employee_document = EmployeeDocument::where('employee_id', $employee->employee_id)->where('document_id', $key)->first();
                            if(!empty($employee_document))
                            {

                                $employee_document->document_value = $fileNameToStore;
                                $employee_document->save();
                            }
                            else
                            {

                                $employee_document                 = new EmployeeDocument();
                                $employee_document->employee_id    = $employee->employee_id;
                                $employee_document->document_id    = $key;

                                $employee_document->document_value = $fileNameToStore;
                                $employee_document->created_by = Auth::user()->creatorId();

                                $employee_document->save();
                            }

                        }
                    }
                }

                $employee = Employee::findOrFail($request->employee_id);
                $input    = $request->all();
                $employee->fill($input)->save();
                $employee = Employee::find($request->employee_id);
                $user = User::where('id',$employee->user_id)->first();
                if(!empty($user)){
                    $user->name = $employee->name;
                    $user->email = $employee->email;
                    $user->save();
                }
                return response([
                    "success" => true,
                    "message" => "Employee successfully updated.",
                ], 200);

            }
            else
            {
                return response([
                    "error" => "Permission denied."
                ], 500);
            }
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function getEmployeeNumber()
    {
        
        $latest = Employee::where('created_by', '=', Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }
        return $latest->employee_id + 1;
    }
}
