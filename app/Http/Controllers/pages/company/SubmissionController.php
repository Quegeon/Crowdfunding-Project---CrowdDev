<?php

namespace App\Http\Controllers\pages\company;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Selection;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function approval()
    {
        $proposal = Proposal::select(['id','title','document','id_user'])
            ->where('status', 'Approval')
            ->where('id_company', Auth::guard('company')->user()->id)
            ->orderByDesc('created_at')
            ->get();

        $ongoing = Proposal::select(['id','title','id_user','document','status'])
            ->where('status', 'Ongoing')
            ->orWhere('status', 'Confirmation')
            ->where('id_company', Auth::guard('company')->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return view('content.pages.company.submission.approval.index-approval', compact('proposal','ongoing'));
    }

    public function download($id)
    {
        $proposal = Proposal::findOrFail($id, ['document']);
        return Storage::download('proposal/' . $id . '.pdf', $proposal->document);
    }

    public function approve($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            $proposal->update(['status' => 'Ongoing']);

            return back()
                ->with('success', 'Successfully Accept Proposal');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function reject($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            Vote::where('id_proposal', $proposal->id)->delete();

            Selection::where('id_proposal', $proposal->id)->update(['is_rejected' => true]);

            $proposal->update([
                'status' => 'Selection',
                'id_company' => null
            ]);

            return back()
                ->with('success', 'Successfully Reject Proposal');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function confirmation($id)
    {
        $proposal = Proposal::findOrFail($id);

        try {
            $proposal->update(['status' => 'Confirmation']);

            return back()
                ->with('success', 'Successfully Ask Client for Done Confirmation');

        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function history()
    {
        return view('content.pages.company.submission.history.index-history');
    }
}
