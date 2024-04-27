<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $my_proposal = Proposal::where('id_user', Auth::user()->id)->pluck('id');

        $count_proposal = Proposal::where('id_user', Auth::user()->id)->count();
        $count_ongoing = Proposal::where('id_user', Auth::user()->id)->whereIn('status', ['Ongoing','Confirmation'])->count();
        $sum_fund = Funding::whereIn('id_proposal', $my_proposal->toArray())->sum('fund');

        $latest = Proposal::select(['title','total_funded','status'])
            ->where('id_user', Auth::user()->id)
            ->whereNotIn('status', ['Ongoing','Confirmation'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $ongoing = Proposal::select(['title','id_company','status'])
            ->where('id_user', Auth::user()->id)
            ->whereIn('status', ['Ongoing','Confirmation'])
            ->orderByDesc('created_at')
            ->get();

        return view('content.pages.user.dashboard-user', compact('count_proposal','sum_fund','count_ongoing','ongoing','latest'));
    }
}
