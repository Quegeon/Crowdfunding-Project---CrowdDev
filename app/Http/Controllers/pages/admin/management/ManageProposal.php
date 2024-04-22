<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Funding;
use App\Models\Proposal;
use App\Models\Selection;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageProposal extends Controller
{
    protected $request, $local;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->local = Storage::disk('local');
    }

    public function index()
    {
        $client = User::select(['id','username'])->get();
        
        if ($client->isEmpty()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Error Required Data');
        }

        $proposal = Proposal::select(['id','title','id_user','document','id_company','total_target','status'])->get();
        return view('content.pages.admin.management.proposal.index-proposal', compact('proposal','client'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'id_user' => 'required|exists:users,id',
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
                'id_user' => $validated['id_user'],
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

    public function show($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','title','id_user','id_company','total_target','status']);

        $client = User::select(['id','username'])->get();

        if ($proposal->status == 'Ongoing') {
            $rejected = Selection::where('id_proposal', $id)
                ->where('is_rejected', true)
                ->pluck('id_company');
            $company = Company::select(['id','company_name','country','work_field'])
                ->whereNotIn('id', $rejected->toArray())
                ->get();

        } else {
            $company = [];
        }

        $render = view('content.pages.admin.management.proposal.component.content-edit', compact('proposal','client','company'));

        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $proposal = Proposal::findOrFail($id);

        if ($proposal->status == 'Funding') {
            $validator = Validator::make($this->request->all(), [
                'title' => 'required|string|min:6|max:100',
                'id_user' => 'required|exists:users,id',
                'document' => 'nullable|file|max:10240|mimetypes:application/pdf',
                'total_target' => 'required|numeric|digits_between:4,10'
            ]);

        } elseif ($proposal->status == 'Ongoing') {
            $validator = Validator::make($this->request->all(), [
                'title' => 'required|string|min:6|max:100',
                'id_user' => 'required|exists:users,id',
                'document' => 'nullable|file|max:10240|mimetypes:application/pdf',
                'id_company' => 'required|exists:companies,id'
            ]);
        } else {
            $validator = Validator::make($this->request->all(), [
                'title' => 'required|string|min:6|max:100',
                'id_user' => 'required|exists:users,id',
                'document' => 'nullable|file|max:10240|mimetypes:application/pdf'
            ]);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            if ($this->request->hasFile('document')) {
                $file = $this->request->file('document');

                $this->local->delete('proposal/' . $id . '.pdf');
                $file->storeAs('proposal', $id . '.pdf', 'local');

                $proposal->document = $file->getClientOriginalName();
            };

            $proposal->title = $validated['title'];
            $proposal->id_user = $validated['id_user'];

            if ($proposal->status == 'Funding') {
                if ($validated['total_target'] < $proposal->total_funded) {
                    return back()
                        ->with('error','Total Target cant go below Total Funded amount');

                } elseif ($validated['total_target'] == $proposal->total_funded) {
                    $proposal->status = 'Selection';
                }

                $proposal->total_target = $validated['total_target'];

            } elseif ($proposal->status == 'Ongoing' && $validated['id_company'] != $proposal->id_company) {
                $proposal->id_company = $validated['id_company'];

                Selection::where('id_proposal', $proposal->id)->delete();
                Selection::create([
                    'id' => Str::orderedUuid(),
                    'id_proposal' => $proposal->id,
                    'id_company' => $validated['id_company'],
                    'is_rejected' => false
                ]);

                Vote::where('id_proposal', $proposal->id)->delete();
                Vote::create([
                    'id' => Str::orderedUuid(),
                    'id_proposal' => $proposal->id,
                    'id_user' => '9bdb0481-7b6c-424c-b45b-bd05ee3fa4d7', //change to auth
                    'id_company' => $validated['id_company'],
                    'is_reject' => false
                ]);
            }

            $proposal->save();
    
            return back()
                ->with('success','Successfully Edit Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            $proposal->delete();
            Funding::where('id_proposal', $id)->delete();
            Selection::where('id_proposal', $id)->delete();
            Vote::where('id_proposal', $id)->delete();

            $this->local->delete('proposal/' . $id . '.pdf');

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function detail($id)
    {
        $proposal = Proposal::findOrFail($id, ['title','id_user','id_company','document','total_target','total_funded','status']);
        $render = view('content.pages.admin.management.proposal.component.content-detail', compact('proposal'));

        return response()->json(['data' => $render->render()]);
    }

    public function download($id)
    {
        $proposal = Proposal::findOrFail($id, ['document']);
        return Storage::download('proposal/' . $id . '.pdf', $proposal->document);
    }

    public function show_selection($id)
    {
        $proposal = Proposal::findOrFail($id, ['id','status']);

        if ($proposal->status != 'Selection') {
            return back()
                ->with('error','Error Invalid Proposal Status');
        }

        $rejected = Selection::where('id_proposal', $id)
            ->where('is_rejected', true)
            ->pluck('id_company');
        $company = Company::select(['id','company_name','country','work_field'])
            ->whereNotIn('id', $rejected->toArray())
            ->get();
        $render = view('content.pages.admin.management.proposal.component.content-selection', compact('proposal','company'));
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
                'status' => 'Ongoing'
            ]);

            $selection = new Selection([
                'id' => Str::orderedUuid(),
                'id_proposal' => $proposal->id,
                'id_company' => $validated['id_company'],
                'is_rejected' => false
            ]);

            $selection->save();

            $vote = new Vote([
                'id' => Str::orderedUuid(),
                'id_proposal' => $proposal->id,
                'id_user' => '9bdb0481-7b6c-424c-b45b-bd05ee3fa4d7', // change to auth
                'id_company' => $validated['id_company'],
                'is_reject' => false
            ]);

            $vote->save();

            return back()
                ->with('success', 'Successfully Select Company Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function done($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            $proposal->update(['status' => 'Done']);

            return back()
                ->with('success', 'Successfully Change Proposal Status');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
