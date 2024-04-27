<?php

namespace App\Http\Controllers\pages\company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Proposal;
use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $is_rejected = Selection::where('is_rejected', true)
            ->where('id_company', Auth::guard('company')->user()->id)
            ->pluck('id_proposal');
        $rejected = Proposal::whereIn('id', $is_rejected)->get();
        $finished = Proposal::where('id_company', Auth::guard('company')->user()->id)
            ->where('status', 'Done')
            ->get();
        $ongoing = Proposal::whereIn('status', ['Ongoing','Confirmation'])
            ->where('id_company', Auth::guard('company')->user()->id)
            ->get();

        return view('content.pages.company.profile.index-profile', compact('finished','ongoing','rejected'));
    }

    public function show(){
        $render = view('content.pages.company.profile.component.content-profile');
        return response()->json(['data' => $render->render()]);
    }

    public function update()
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

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
