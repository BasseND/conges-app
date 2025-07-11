<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\HandlesLeaveApproval;

class LeaveController extends Controller
{
    use HandlesLeaveApproval;

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,hr']);
    }

    /**
     * Affiche la liste des demandes de congés pour l'administrateur
     */
    public function index(Request $request)
    {
        $query = Leave::with(['user', 'user.department']);

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

        // Filtre par département
        if ($request->filled('department')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
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
        $leaves->appends($request->only(['search', 'department', 'status', 'type', 'date_from', 'date_to']));

        $departments = Department::orderBy('name')->get();

        return view('admin.leaves.index', compact('leaves', 'departments'));
    }

    /**
     * Approuve une demande de congé
     */

    public function approve(Leave $leave)
    {
        if ($this->approveLeave($leave)) {
            return back()->with('success', 'La demande de congé a été approuvée.');
        }
        return back()->withErrors(['error' => 'Échec de l\'approbation']);
    }
    
    /**
     * Rejette une demande de congé
     */

     public function reject(Request $request, Leave $leave)
    {
        if ($this->rejectLeave($request, $leave)) {
            return back()->with('success', 'Demande de congé rejetée avec succès');
        }
        return back()->withErrors(['error' => 'Échec du rejet']);
    }
    
}
