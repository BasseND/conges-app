<?php

namespace App\Http\Controllers\Head;

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
            if (!auth()->user()->isDepartmentHead() && !auth()->user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Leave::with(['user', 'user.department']);

        // Si c'est un manager, il ne voit que les demandes de son département
        if (!$user->isAdmin()) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
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

        return view('head.leaves.index', compact('leaves'));
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

    /**
     * Retourne les données de congés au format JSON pour le calendrier
     */
    public function getCalendarData(Request $request)
    {
        $user = auth()->user();
        
        $query = Leave::with(['user', 'user.department']);

        // Si c'est un chef de département, il ne voit que les demandes de son département
        if (!$user->isAdmin()) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        // Appliquer les mêmes filtres que dans la méthode index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && array_key_exists($request->status, Leave::STATUSES)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type') && array_key_exists($request->type, Leave::TYPES)) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->get();

        // Transformer les données pour FullCalendar
        $events = $leaves->map(function ($leave) {
            $statusColors = [
                'pending' => '#f59e0b', // orange
                'approved' => '#10b981', // vert
                'rejected' => '#ef4444', // rouge
                'draft' => '#6b7280', // gris
            ];

            return [
                'id' => $leave->id,
                'title' => $leave->user->first_name . ' ' . $leave->user->last_name . ' - ' . Leave::TYPES[$leave->type],
                'start' => $leave->start_date,
                'end' => $leave->end_date,
                'backgroundColor' => $statusColors[$leave->status] ?? '#6b7280',
                'borderColor' => $statusColors[$leave->status] ?? '#6b7280',
                'extendedProps' => [
                    'employee' => $leave->user->first_name . ' ' . $leave->user->last_name,
                    'department' => $leave->user->department->name ?? 'N/A',
                    'type' => Leave::TYPES[$leave->type],
                    'status' => Leave::STATUSES[$leave->status],
                    'duration' => $leave->duration,
                    'reason' => $leave->reason,
                    'url' => route('leaves.show', $leave)
                 ]
            ];
        });

        return response()->json($events);
    }
}