<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Proposal;
use App\Models\Selection;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
            'password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9 ]+$/',
            'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9 ]+$/',
            'work_field' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s, ]+$/',
            'country' => 'required|string',
            'company_email' => 'required|string|email|max:50|unique:companies,company_email',
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
                'country' => Str::lower($validated['country']),
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

    public function detail($id)
    {
        $company = Company::findOrFail($id, ['id','username','company_name','work_field','country','company_email','company_description','name','position','personal_email']);
        $render = view('content.pages.admin.management.company.component.content-detail', compact('company'));
        return response()->json(['data' => $render->render()]);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id, ['id','username','company_name','work_field','country','company_email','company_description','name','position','personal_email']);
        $render = view('content.pages.admin.management.company.component.content-edit', compact('company'));
        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $company = Company::findOrFail($id);

        if ($this->request->company_email == $company->company_email) {
            $validator = Validator::make($this->request->all(), [
                'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
                'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9 ]+$/',
                'work_field' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s, ]+$/',
                'country' => 'required|string',
                'company_email' => 'required|string|email|max:50',
                'company_description' => 'nullable|string|max:255',
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
                'position' => 'required|string|max:50|regex:/^[a-zA-Zs ]+$/',
                'personal_email' => 'required|string|email|max:50'
            ]);

        } else {
            $validator = Validator::make($this->request->all(), [
                'username' => 'required|string|max:30|min:6|regex:/^[a-zA-Z0-9 ]+$/',
                'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9 ]+$/',
                'work_field' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s, ]+$/',
                'country' => 'required|string',
                'company_email' => 'required|string|email|max:50|unique:companies,company_email',
                'company_description' => 'nullable|string|max:255',
                'name' => 'required|string|max:255|regex:/^[a-zA-Zs ]+$/',
                'position' => 'required|string|max:50|regex:/^[a-zA-Zs ]+$/',
                'personal_email' => 'required|string|email|max:50'
            ]);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $validated = $validator->validated();

        try {
            $company->update([
                'username' => $validated['username'],
                'company_name' => $validated['company_name'],
                'work_field' => $validated['work_field'],
                'country' => Str::lower($validated['country']),
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

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        try {
            $company->delete();

            $proposal = Proposal::where('id_company', $id)->get();

            if ($proposal) {
                foreach ($proposal as $p) {
                    Storage::disk('local')->delete('proposal/' . $p->id . '.pdf');
                    Selection::where('id_proposal', $p->id)->delete();
                    Vote::where('id_proposal', $p->id)->delete();
                    $p->delete();
                };
            };

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function show_password($id)
    {
        $dataId = Company::findOrFail($id, ['id']);
        $render = view('content.pages.admin.management.company.component.content-change-password', compact('dataId'));
        return response()->json(['data' => $render->render()]);
    }

    public function visibility_password($id)
    {
        $encrypt = Company::findOrFail($id, ['encrypt_view']);
        $decrypt = decrypt($encrypt->encrypt_view);
        return response()->json(['data' => $decrypt]);
    }

    public function update_password($id)
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($this->request->all(), [
            'new_password' => 'required|string|max:20|min:8|regex:/^[a-zA-Z0-9]+$/'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        };

        $validated = $validator->validated();

        try {
            $company->update([
                'password' => bcrypt($validated['new_password']),
                'encrypt_view' => encrypt($validated['new_password'])
            ]);
            
            $company->save();

            return back()
                ->with('success', 'Successfully Change Password');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
