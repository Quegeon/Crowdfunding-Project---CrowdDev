<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Funding;
use App\Models\Proposal;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

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

    public function company_selection()
    {
        $not_client = Proposal::where('id_user', Auth::user()->id)->pluck('id');
        $not_voted = Vote::where('id_user', Auth::user()->id)->pluck('id_proposal');
        $my_funding = Funding::where('id_user', Auth::user()->id)
            ->whereNotIn('id_proposal', $not_client->toArray())
            ->pluck('id_proposal')
            ->unique('id_proposal');

        $proposal = Proposal::select(['id','id_user','title','document'])
            ->where('status', 'Voting')
            ->whereIn('id', $my_funding->toArray())
            ->whereNotIn('id', $not_voted->toArray())
            ->get();

        return view('content.pages.user.company.select-company.index-select-company', compact('proposal'));
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);
        $count_sponsor = Funding::where('id_proposal', $proposal->id)->count();
    }

    public function reject($id)
    {
        
    }
}
