<?php

namespace App\Http\Controllers\pages\admin\management;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageFunding extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $proposal = Proposal::select(['id','title','total_target','total_funded'])
            ->where('status','Funding')
            ->get();
        $user = User::select(['id','username'])->get();

        if ($user->isEmpty()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Error Required Data');
        };

        $funding = Funding::select(['id','id_proposal','id_user','fund','created_at'])->orderBy('created_at','desc')->get();

        return view('content.pages.admin.management.funding.index-funding', compact('proposal','user','funding'));
    }

    public function store()
    {
        $validator = Validator::make($this->request->all(), [
            'id_proposal' => 'required|exists:proposals,id',
            'id_user' => 'required|exists:users,id',
            'fund' => 'required|numeric|digits_between:4,10'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $proposal = Proposal::find($validated['id_proposal']);
        $new_fund = $validated['fund'] + $proposal->total_funded;

        if ($new_fund > $proposal->total_target) {
            return back()
                ->with('error','New Fund Exceed Total Target')
                ->withInput();
        }

        try {
            $funding = new Funding([
                'id' => Str::orderedUuid(),
                'id_proposal' => $validated['id_proposal'],
                'id_user' => $validated['id_user'],
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

    public function show($id)
    {
        $funding = Funding::findOrFail($id, ['id','id_proposal','id_user','fund']);
        $proposal = Proposal::select(['id','title','total_target','total_funded'])
            ->where('status','Funding')
            ->get();
        $user = User::select(['id','username'])->get();
        $render = view('content.pages.admin.management.funding.component.content-edit', compact('funding','proposal','user'));
        return response()->json(['data' => $render->render()]);
    }

    public function update($id)
    {
        $funding = Funding::findOrFail($id);

        $validator = Validator::make($this->request->all(), [
            'id_proposal' => 'required|exists:proposals,id',
            'id_user' => 'required|exists:users,id',
            'fund' => 'required|numeric|digits_between:4,10'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $proposal = Proposal::find($validated['id_proposal']);
        $new_fund = $proposal->total_funded - $funding->fund + $validated['fund'];

        if ($new_fund > $proposal->total_target) {
            return back()
                ->with('error','New Fund Exceed Total Target')
                ->withInput();
        }

        try {
            $funding->update([
                'id_proposal' => $validated['id_proposal'],
                'id_user' => $validated['id_user'],
                'fund' => $validated['fund'] 
            ]);

            $proposal->update(['total_funded' => $new_fund]);

            if ($proposal->total_funded == $proposal->total_target) {
                $proposal->update(['status' => 'Selection']);

            } else {
                $proposal->update(['status' => 'Funding']);
            }

            return back()
                ->with('success', 'Successfully Edit Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $funding = Funding::findOrFail($id);
        $proposal = Proposal::find($funding->id_proposal);

        try {
            if ($proposal->status == 'Funding' || $proposal->status == 'Selection' && !$proposal->id_company) {
                $new_fund = $proposal->total_funded - $funding->fund;
                $proposal->update([
                    'total_funded' => $new_fund,
                    'status' => 'Funding'
                ]);
            }

            $funding->delete();

            return back()
                ->with('success', 'Successfully Delete Data');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }
}
