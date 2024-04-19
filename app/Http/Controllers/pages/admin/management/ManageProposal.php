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
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $proposal = Proposal::select(['id','title','id_user','id_company','total_target','status'])->get();
        $client = User::select(['id','username'])->get();
        return view('content.pages.admin.management.proposal.index-proposal', compact('proposal','client'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'title' => 'required|string|min:6|max:100',
            'id_user' => 'required',
            'document' => 'required|file|max:10240|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword',
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
            Storage::disk('local')->put($ouuid . '.' . $file->getClientOriginalExtension(), $file);

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
}
