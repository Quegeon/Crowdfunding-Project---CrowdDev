<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $funding = Funding::where('id_user', Auth::user()->id)->get()->unique('id_proposal');
        return view('content.pages.user.proposal.view-proposal.index-view-proposal', compact('proposal','funding'));
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

    public function fund($id)
    {
        $proposal = Proposal::findOrFail($id);

        $validator = Validator::make($this->request->all(), ['fund' => 'required|numeric|digits_between:4,10']);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $new_fund = $validated['fund'] + $proposal->total_funded;

        if ($new_fund > $proposal->total_target) {
            return back()
                ->with('error','New Fund Exceed Total Target')
                ->withInput();
        }

        try {
            $funding = new Funding([
                'id' => Str::orderedUuid(),
                'id_proposal' => $proposal->id,
                'id_user' => Auth::user()->id,
                'fund' => $validated['fund']
            ]);

            $funding->save();
            $proposal->update(['total_funded' => $new_fund]);

            if ($proposal->total_funded == $proposal->total_target) {
                $proposal->update(['status' => 'Selection']);
            }

            return back()
                ->with('success', 'Successfully Add Data');

        } catch (\Exception $e) { 
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function detail($id)
    {
        $funding = Funding::select(['id','id_user','fund','created_at'])
            ->where('id_proposal', $id)
            ->get();
        $render = view('content.pages.user.proposal.view-proposal.component.content-fund-detail', compact('funding'));
        return response()->json(['data' => $render->render()]);
    }
}
