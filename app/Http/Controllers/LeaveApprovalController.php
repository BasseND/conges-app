<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:approve-leaves']);
    }

    public function approve(Request $request, Leave $leave)
    {
        if (!$leave->canBeApproved()) {
            return back()->withErrors(['error' => 'Cette demande ne peut pas être approuvée.']);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Notification à l'employé
        $leave->user->notify(new \App\Notifications\LeaveStatusUpdated($leave));

        return back()->with('success', 'La demande de congé a été approuvée.');
    }

    public function reject(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        if (!$leave->canBeRejected()) {
            return back()->withErrors(['error' => 'Cette demande ne peut pas être rejetée.']);
        }

        $leave->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Notification à l'employé
        $leave->user->notify(new \App\Notifications\LeaveStatusUpdated($leave));

        return back()->with('success', 'La demande de congé a été rejetée.');
    }

    public function pending()
    {
        $user = Auth::user();
        
        $leaves = $user->isAdmin()
            ? Leave::pending()->with(['user', 'approver'])->latest()->paginate(10)
            : Leave::pending()
                ->whereHas('user', function($query) use ($user) {
                    $query->where('department_id', $user->department_id);
                })
                ->with(['user', 'approver'])
                ->latest()
                ->paginate(10);

        return view('leaves.pending', compact('leaves'));
    }
}
