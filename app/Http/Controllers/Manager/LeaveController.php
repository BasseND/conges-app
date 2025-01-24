<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

     public function indexautres(Request $request)
    {
        $user = auth()->user();
        
        $query = Leave::with(['user', 'user.teams']);

        // Si c'est un manager, il ne voit que les demandes des membres de son équipe
        if (!$user->isAdmin()) {
            $query->whereHas('user.teams', function ($q) use ($user) {
                $q->whereHas('manager', function ($q) use ($user) {
                    $q->where('id', $user->id);
                });
            });
        }

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status') && array_key_exists($request->status, Leave::STATUSES)) {
            $query->where('status', $request->status);
        }

        $leaves = $query->latest()->paginate(10);
        
        return view('manager.leaves.index', [
            'leaves' => $leaves,
            'statuses' => Leave::STATUSES
        ]);
    }


    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Leave::with(['user', 'user.teams']);

        // Si c'est un manager, il ne voit que les demandes des membres de son équipe
        if (!$user->isAdmin()) {
            $query->whereHas('user.teams', function ($q) use ($user) {
                $q->whereHas('manager', function ($q) use ($user) {
                    $q->where('id', $user->id);
                });
            });
        }

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status') && array_key_exists($request->status, Leave::STATUSES)) {
            $query->where('status', $request->status);
        }

        // Filtre par type de congé
        if ($request->filled('type') && array_key_exists($request->type, Leave::TYPES)) {
            $query->where('type', $request->type);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->latest()->paginate(10);
        
        // Conserver les paramètres de filtrage dans les liens de pagination
        $leaves->appends($request->only(['search', 'status', 'type', 'date_from', 'date_to']));

        return view('manager.leaves.index', compact('leaves'));
    }

    public function approve(Leave $leave)
    {
        if (!auth()->user()->canManageUserLeaves($leave->user)) {
            abort(403, 'Vous n\'avez pas le droit de gérer les congés de cet employé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande de congé a déjà été traitée.');
        }

        $leave->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now()
        ]);

        // Mettre à jour le solde de congés de l'employé
        if ($leave->type === 'annual') {
            $leave->user->decrement('annual_leave_days', $leave->duration);
        } elseif ($leave->type === 'sick') {
            $leave->user->decrement('sick_leave_days', $leave->duration);
        }

        return back()->with('success', 'La demande de congé a été approuvée.');
    }

    public function reject(Leave $leave)
    {
        if (!auth()->user()->canManageUserLeaves($leave->user)) {
            abort(403, 'Vous n\'avez pas le droit de gérer les congés de cet employé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande de congé a déjà été traitée.');
        }

        $leave->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
            'processed_at' => now()
        ]);

        return back()->with('success', 'La demande de congé a été rejetée.');
    }
}
