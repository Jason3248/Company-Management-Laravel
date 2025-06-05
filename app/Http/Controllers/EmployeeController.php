<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Country;

class EmployeeController extends Controller

{
    //1. Fetching all existing employees for displaying 

    public function index(){
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }


    //2. Redirecting to the employees.create with companies injected in the view for dropdown

    public function create(){
    $companies = Company::all();
    return view('employees.create', compact('companies'));
}

    //3. POST request handler for storing new employee.

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
             'email' => 'required|email|unique:employees',
            'position' => 'required',
            'company_id' => 'required',
            'manager_id' => 'nullable',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    //4. Deleting an employee

    public function destroy(Employee $employee){
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    //5. Redirecting to edit employee page similarly injections($companies, $managers) for dropdowns.

    public function edit(Employee $employee){
        $companies = Company::all();
        $managers = Employee::where('company_id', $employee->company_id)->where('position', 'Manager')
        ->where('id', '!=', $employee->id)->get();

    return view('employees.edit', compact('employee', 'companies', 'managers'));
    }

    //6. POST route handler for updating an existing employee

    public function update(Request $request, Employee $employee){
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:employees,email,{$employee->id}",
            'position' => 'required',
            'company_id' => 'required',
            'manager_id' => 'nullable',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    //7. Fetching company specific managers for displaying them in a dropdown after company selection.

    public function getManagers($companyId){
        $managers = Employee::where('company_id', $companyId)->where('position', 'Manager')->get();
        return response()->json($managers);
    }


}
