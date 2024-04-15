<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ManageCompany extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $company = Company::select(['id','company_name','username','company_email','name'])->get();
        return view('content.pages.admin.management.company.index-company', compact('company'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'username' => 'required|string|max:30|min:6|unique:companies,username|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9 ]+$/',
            'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9 ]+$/',
            'work_field' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s, ]+$/',
            'country' => 'required|string',
            'company_email' => 'required|string|email|max:50',
            'company_description' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
            'position' => 'required|string|max:50|regex:/^[a-zA-Zs ]+$/',
            'personal_email' => 'required|string|email|max:50'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $validated = $validator->validated();

        try {
            $company = new Company([
                'id' => Str::orderedUuid(),
                'username' => $validated['username'],
                'password' => bcrypt($validated['password']),
                'encrypt_view' => encrypt($validated['password']),
                'company_name' => $validated['company_name'],
                'work_field' => $validated['work_field'],
                'country' => $validated['country'],
                'company_email' => $validated['company_email'],
                'company_description' => $validated['company_description'],
                'name' => $validated['name'],
                'position' => $validated['position'],
                'personal_email' => $validated['personal_email']
            ]);

            $company->save();

            return back()
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}