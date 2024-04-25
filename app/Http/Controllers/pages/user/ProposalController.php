<?php

namespace App\Http\Controllers\pages\user;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Funding;
use App\Models\Proposal;
use App\Models\Selection;
use App\Models\Vote;
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

        return view('content.pages.user.proposal.view-proposal.index-view-proposal', compact('proposal','funding'));
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

    public function show_fund($id, $is_view_proposal)
    {
        $proposal = Proposal::findOrFail($id, ['id','title','total_target','total_funded']);
        if ($is_view_proposal) {
            $render = view('content.pages.user.proposal.view-proposal.component.content-fund', compact('proposal'));

        } else {
            $render = view('content.pages.user.proposal.my-proposal.component.content-fund', compact('proposal'));
        }
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

        if ($proposal->id_user == Auth::user()->id) {
            $exist_other_fund = Funding::where('id_proposal', $proposal->id)
                ->where('id_user', '!=', $proposal->id_user)
                ->count();

            if ($exist_other_fund == 0 && $new_fund >= $proposal->total_target) {
                return back()
                    ->with('error',"Client can't do the funding process alone")
                    ->withInput();
            }
        }

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

    public function detail_funding_vp($id)
    {
        $funding = Funding::select(['id','id_user','fund','created_at'])
            ->where('id_proposal', $id)
            ->get();
        $render = view('content.pages.user.proposal.view-proposal.component.content-fund-detail', compact('funding'));
        return response()->json(['data' => $render->render()]);
    }

    // My Proposal
    public function my_proposal()
    {
        $proposal = Proposal::select(['id','title','document','id_company','total_funded','total_target','status'])
            ->where('id_user', Auth::user()->id)
            ->orderBy('created_at','desc')
            ->get();

        return view('content.pages.user.proposal.my-proposal.index-my-proposal', compact('proposal'));
    }

    public function detail_mp($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','title','document','total_target','total_funded','id_company']);
        $funding = Funding::select(['id_user','fund','created_at'])->where('id_proposal', $id)->orderBy('created_at','desc')->get();
        $vote = Vote::select(['id_user','created_at','is_reject'])->where('id_proposal', $id)->orderBy('created_at','desc')->get();

        $render = view('content.pages.user.proposal.my-proposal.component.content-detail', compact('proposal','funding','vote'));
        return response()->json(['data' => $render->render()]);
    }

    public function destroy_proposal($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            $proposal->delete();
            Funding::where('id_proposal', $id)->delete();
            Selection::where('id_proposal', $id)->delete();
            Vote::where('id_proposal', $id)->delete();

            Storage::disk('local')->delete('proposal/' . $id . '.pdf');

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function show_edit($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','title','total_target','status']);
        $render = view('content.pages.user.proposal.my-proposal.component.content-edit', compact('proposal'));

        return response()->json(['data' => $render->render()]);
    }

    public function update_proposal($id)
    {
        $proposal = Proposal::findOrFail($id);

        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'document' => 'nullable|file|max:10240|mimetypes:application/pdf',
            'total_target' => 'required|numeric|digits_between:4,10'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            if ($this->request->hasFile('document')) {
                $file = $this->request->file('document');

                Storage::disk('local')->delete('proposal/' . $id . '.pdf');
                $file->storeAs('proposal', $id . '.pdf', 'local');

                $proposal->document = $file->getClientOriginalName();
            };

            $proposal->title = $validated['title'];

            if ($validated['total_target'] < $proposal->total_funded) {
                return back()
                    ->with('error','Total Target cant go below Total Funded amount');

            } elseif ($validated['total_target'] == $proposal->total_funded) {
                $proposal->status = 'Selection';
            }

            $proposal->total_target = $validated['total_target'];
            $proposal->save();
    
            return back()
                ->with('success','Successfully Edit Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function show_selection($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','status']);
        $rejected = Selection::where('id_proposal', $id)
            ->where('is_rejected', true)
            ->pluck('id_company');
        $company = Company::select(['id','company_name','country','work_field'])
            ->whereNotIn('id', $rejected->toArray())
            ->get();
        $render = view('content.pages.user.proposal.my-proposal.component.content-selection', compact('proposal','company'));
        return response()->json(['data' => $render->render()]);
    }

    public function company_select($id)
    {
        $proposal = Proposal::findOrFail($id);

        $validator = Validator::make($this->request->all(), ['id_company' => 'required|exists:companies,id']);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            $proposal->update([
                'id_company' => $validated['id_company'],
                'status' => 'Voting'
            ]);

            $selection = new Selection([
                'id' => Str::orderedUuid(),
                'id_proposal' => $proposal->id,
                'id_company' => $validated['id_company'],
                'is_rejected' => false
            ]);

            $selection->save();

            return back()
                ->with('success', 'Successfully Select Company Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
    