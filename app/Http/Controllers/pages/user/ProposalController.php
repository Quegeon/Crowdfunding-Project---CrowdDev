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
        $not_client = Proposal::where('id_user', Auth::user()->id)->pluck('id');

        $proposal = Proposal::select(['id','title','id_user','document','total_target','total_funded'])
            ->where('status', 'Funding')
            ->whereNotIn('id', $not_client)
            ->orderBy('created_at','desc')
            ->get();
        $funding = Funding::where('id_user', Auth::user()->id)
            ->whereNotIn('id_proposal', $not_client)
            ->orderBy('created_at','desc')
            ->get()
            ->unique('id_proposal');
        // $vote = Proposal::select(['id','document'])
        //     ->where('status', 'Voting')
        //     ->whereNotIn('id', $not_client)
        //     ->orderBy('created_at','desc')
        //     ->get();

        return view('content.pages.user.proposal.view-proposal.index-view-proposal', compact('proposal','funding'));
    }

    public function my_proposal()
    {
        $proposal = Proposal::select(['id','title','document','id_company','total_funded','total_target','status'])
            ->where('id_user', Auth::user()->id)
            ->orderBy('created_at','desc')
            ->get();

        return view('content.pages.user.proposal.my-proposal.index-my-proposal', compact('proposal'));
    }

    public function store_proposal()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'document' => 'required|file|max:10240|mimetypes:application/pdf',
            'total_target' => 'required|numeric|digits_between:4,10'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $file = $this->request->file('document');

        try {
            $ouuid = Str::orderedUuid();
            $file->storeAs('proposal', $ouuid . '.pdf', 'local');

            $proposal = new Proposal([
                'id' => $ouuid,
                'title' => $validated['title'],
                'id_user' => Auth::user()->id,
                'document' => $file->getClientOriginalName(),
                'total_target' => $validated['total_target'],
                'status' => 'Funding'
            ]);

            $proposal->save();

            return back()
                ->with('success','Successfully Add Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
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

    public function detail_funding($id, $is_view_proposal)
    {
        $funding = Funding::select(['id','id_user','fund','created_at'])
            ->where('id_proposal', $id)
            ->get();
        if ($is_view_proposal) {
            $render = view('content.pages.user.proposal.view-proposal.component.content-fund-detail', compact('funding'));

        } else {
            $render = view('content.pages.user.proposal.view-proposal.component.content-fund-detail', compact('funding'));
        }
        return response()->json(['data' => $render->render()]);
    }
}
