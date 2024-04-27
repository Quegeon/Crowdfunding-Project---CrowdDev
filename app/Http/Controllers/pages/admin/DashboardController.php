<?php

namespace App\Http\Controllers\pages\admin;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\Proposal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count_proposal = Proposal::count();
        $count_ongoing = Proposal::whereIn('status', ['Ongoing','Confirmation'])->count();
        $sum_fund = Funding::sum('fund');

        return view('content.pages.admin.dashboard-admin', compact('count_proposal','sum_fund','count_ongoing'));
    }
}
