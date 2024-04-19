<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\User;
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
        
        if (!$client) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Error Client Data');
        };

        $proposal = Proposal::select(['id','title','id_user','document','id_company','total_target','status'])->get();
        return view('content.pages.admin.management.proposal.index-proposal', compact('proposal','client'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'id_user' => 'required',
            'document' => 'required|file|max:10240|mimetypes:application/pdf',
            'total_target' => 'required|numeric|digits_between:4,11'
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
            $this->local->put($ouuid . '.pdf', $file);

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
        $proposal = Proposal::findOrFail($id, ['id','title','id_user','total_target']);
        $client = User::select(['id','username'])->get();
        $render = view('content.pages.admin.management.proposal.component.content-edit', compact('proposal','client'));
        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $proposal = Proposal::findOrFail($id);

        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'id_user' => 'required',
            'document' => 'nullable|file|max:10240|mimetypes:application/pdf',
            'total_target' => 'required|numeric|digits_between:4,11'
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

                $this->local->deleteDirectory($id . '.pdf');
                $this->local->put($id . 'pdf', $file);

                $proposal->document = $file->getClientOriginalName();
            };

            $proposal->title = $validated['title'];
            $proposal->id_user = $validated['id_user'];
            $proposal->total_target = $validated['total_target'];
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

            $this->local->deleteDirectory($id . '.pdf');

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
