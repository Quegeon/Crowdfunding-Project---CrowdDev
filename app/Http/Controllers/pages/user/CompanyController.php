<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Funding;
use App\Models\Proposal;
use App\Models\Selection;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $ongoing = Proposal::whereIn('status', ['Ongoing','Confirmation'])
            ->where('id_company', $company->id)
            ->count();
        $render = view('content.pages.user.company.view-company.component.content-detail', compact('company','finished','ongoing'));
        return response()->json(['data' => $render->render()]);

    }

    public function company_selection()
    {
        $voted = Vote::where('id_user', Auth::user()->id)->pluck('id_proposal');
        $funded = Funding::where('id_user', Auth::user()->id)->pluck('id_proposal')->unique();

        $proposal = Proposal::select(['id','id_user','title','id_company'])
            ->where('status', 'Voting')
            ->where('id_user', '!=', Auth::user()->id)
            ->whereIn('id', $funded->toArray())
            ->whereNotIn('id', $voted->toArray())
            ->get();

        return view('content.pages.user.company.select-company.index-select-company', compact('proposal'));
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);

        $count_sponsor = Funding::where('id_proposal', $proposal->id)
            ->where('id_user', '!=', $proposal->id_user)
            ->count();

        try {
            if ($count_sponsor < 3) {
                $vote = new Vote([
                    'id' => Str::orderedUuid(),
                    'id_proposal' => $proposal->id,
                    'id_user' => Auth::user()->id,
                    'id_company' => $proposal->id_company,
                    'is_reject' => false
                ]);
                
                $vote->save();

                $proposal->update(['status' => 'Approval']);

            } else {
                $vote = new Vote([
                    'id' => Str::orderedUuid(),
                    'id_proposal' => $proposal->id,
                    'id_user' => Auth::user()->id,
                    'id_company' => $proposal->id_company,
                    'is_reject' => false
                ]);

                $vote->save();

                $calc = floor($count_sponsor / 2);
                $count_vote = Vote::where('id_proposal', $proposal->id)->where('is_reject', false)->count();

                if ($calc == $count_vote) {
                    $proposal->update(['status' => 'Approval']);
                }
            }

            return back()
                ->with('success','Successfully Approve Company Selection');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function reject($id)
    {
        $proposal = Proposal::findOrFail($id);

        $count_sponsor = Funding::where('id_proposal', $proposal->id)
            ->where('id_user', '!=', $proposal->id_user)
            ->count();

        try {
            if ($count_sponsor < 3) {
                Vote::where('id_proposal', $proposal->id)->delete();

                Selection::where('id_proposal', $proposal->id)->update(['is_rejected' => true]);

                $proposal->update([
                    'id_company' => null,
                    'status' => 'Selection'
                ]);

            } else {
                $vote = new Vote([
                    'id' => Str::orderedUuid(),
                    'id_proposal' => $proposal->id,
                    'id_user' => Auth::user()->id,
                    'id_company' => $proposal->id_company,
                    'is_reject' => true
                ]);

                $vote->save();

                $calc = ceil($count_sponsor / 2);
                $count_vote = Vote::where('id_proposal', $proposal->id)->where('is_reject', true)->count();

                if ($calc == $count_vote) {
                    Vote::where('id_proposal', $proposal->id)->delete();

                    Selection::where('id_proposal', $proposal->id)->update(['is_rejected' => true]);
    
                    $proposal->update([
                        'id_company' => null,
                        'status' => 'Selection'
                    ]);
                }
            }

            return back()
                ->with('success','Successfully Reject Company Selection');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
