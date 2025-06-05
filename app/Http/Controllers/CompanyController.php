<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;



class CompanyController extends Controller
{
    //1. Fetching all companies for displaying purposes

    public function index(){
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    //2. Redirecting to the Create Company Page

    public function create(){
        return view('companies.create');
    }

    //3. POST route handler for storing(adding) a new company

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        Company::create($request->all());
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    //4. Deleting a company 

    public function destroy(Company $company){
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    //5. Redirecting to the Edit Company page

    public function edit(Company $company){
        return view('companies.edit', compact('company'));
    }

    //6. Route handler for updating attribute values of an existing company.

    public function update(Request $request, Company $company){
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        $company->update($request->all());
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

}
