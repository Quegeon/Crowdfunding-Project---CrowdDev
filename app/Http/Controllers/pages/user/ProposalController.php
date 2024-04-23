<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view_proposal()
    {
        $proposal = Proposal::select(['id','title','id_user','document','total_target','total_funded'])
            ->where('status', 'Funding')
            ->get();
        return view('content.pages.user.proposal.view-proposal.index-view-proposal', compact('proposal'));
    }

    public function download($id)
    {
        $proposal = Proposal::findOrFail($id, ['document']);
        return Storage::download('proposal/' . $id . '.pdf', $proposal->document);
    }

    public function show_fund($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','title','total_target','total_funded']);
        $render = view('content.pages.user.proposal.view-proposal.component.content-fund', compact('proposal'));
        return response()->json(['data' => $render->render()]);
    }
}
