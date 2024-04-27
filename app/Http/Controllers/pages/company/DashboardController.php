<?php

namespace App\Http\Controllers\pages\company;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $count_approved = Proposal::where('id_company', Auth::guard('company')->user()->id)->where('status', 'Approval')->count();
        $count_finished = Proposal::where('id_company', Auth::guard('company')->user()->id)->where('status', 'Done')->count();
        $count_rejected = Selection::where('id_company', Auth::guard('company')->user()->id)->where('is_rejected', true)->count();
        
        return view('content.pages.company.dashboard-company', compact('count_approved','count_finished','count_rejected'));
    }
}
