<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\LeaveStatusNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Concerns\HandlesLeaveApproval;

class LeaveApprovalController extends Controller
{
    use HandlesLeaveApproval;

    public function __construct()
    {
        $this->middleware(['auth', 'can:approve-leaves']);
    }


    public function approve(Leave $leave)
    {
        if ($this->approveLeave($leave)) {
            return back()->with('success', 'La demande de congé a été approuvée.');
        }
        return back()->withErrors(['error' => 'Échec de l\'approbation']);
    }

    public function reject(Request $request, Leave $leave)
    {
        if ($this->rejectLeave($request, $leave)) {
            return back()->with('success', 'Demande de congé rejetée avec succès');
        }
        return back()->withErrors(['error' => 'Échec du rejet']);
    }

    public function pending()
    {
        $user = Auth::user();
        
        $leaves = $user->isAdmin()
            ? Leave::pending()->with(['user', 'approver'])->latest()->paginate(20)
            : Leave::pending()
                ->whereHas('user', function($query) use ($user) {
                    $query->where('department_id', $user->department_id);
                })
                ->with(['user', 'approver'])
                ->latest()
                ->paginate(20);

        return view('leaves.pending', compact('leaves'));
    }
}
