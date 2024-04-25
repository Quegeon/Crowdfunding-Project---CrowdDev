<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Proposal;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function view_company()
    {
        $company = Company::select(['id','company_name','name','company_email','work_field'])->get();
        return view('content.pages.user.company.view-company.index-view-company', compact('company'));
    }

    public function detail_company($id)
    {
        $company = Company::findOrFail($id, ['id','company_name','work_field','country','company_email','company_description','name','position','personal_email']);
        $finished = Proposal::where('id_company', $company->id)
            ->where('status', 'Done')
            ->count();
        $ongoing = Proposal::where('status', 'Ongoing')
            ->orWhere('status', 'Confirmation')
            ->where('id_company', $company->id)
            ->count();
        $render = view('content.pages.user.company.view-company.component.content-detail', compact('company','finished','ongoing'));
        return response()->json(['data' => $render->render()]);

    }
}
