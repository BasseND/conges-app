<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Department;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Department $department)
    {
        return $this->getTeamsByDepartment($department);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'members' => 'array',
            'members.*' => 'exists:users,id'
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
                $team = Team::create([
                    'name' => $validated['name'],
                    'manager_id' => $validated['manager_id'],
                    'department_id' => $validated['department_id']
                ]);

                // Synchroniser les membres si présents
                if ($request->has('members')) {
                    $team->members()->sync($request->members);
                }
            });

            return redirect()->back()->with('success', 'Équipe créée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de l\'équipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'équipe.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   

     public function edit(Department $department, Team $team)
    {
        if ($team->department_id !== $department->id) {
            return response()->json(['error' => 'L\'équipe n\'appartient pas à ce département'], 404);
        }

        return response()->json([
            'name' => $team->name,
            'manager_id' => $team->manager_id,
            'members' => $team->members->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
   

    public function update(Request $request, Department $department, Team $team)
    {
        if ($team->department_id !== $department->id) {
            return response()->json(['error' => 'L\'équipe n\'appartient pas à ce département'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id',
            'members' => 'array',
            'members.*' => 'exists:users,id'
        ]);

        try {
            DB::transaction(function () use ($team, $validated, $request) {
                $team->update([
                    'name' => $validated['name'],
                    'manager_id' => $validated['manager_id']
                ]);
                
                // Mise à jour des membres
                if ($request->has('members')) {
                    $team->members()->sync($request->members);
                }
            });

            return redirect()->back()->with('success', 'Équipe mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'équipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'équipe.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
 

    public function destroy(Team $team)
    {
        try {
            DB::transaction(function () use ($team) {
                // Détacher d'abord tous les membres
                $team->members()->detach();
                // Supprimer l'équipe
                $team->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Équipe supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'équipe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Une erreur est survenue lors de la suppression de l\'équipe'
            ], 500);
        }
    }

    public function getManagersByDepartment($departmentId)
    {
        Log::info('Récupération des managers pour le département: ' . $departmentId);
        
        $managers = User::where('department_id', $departmentId)
            ->where('role', 'manager')
            ->get(['id', 'name']);
        Log::info('Managers trouvés: ' . $managers->count(), ['managers' => $managers->toArray()]);

        return response()->json($managers);
    }

    public function getTeamsByDepartment(Department $department)
    {
        Log::info('Récupération des équipes pour le département: ' . $department->id);
        
        try {
            $teams = $department->teams()->with('manager:id,first_name,last_name')->get();
            Log::info('Équipes trouvées: ' . $teams->count(), ['teams' => $teams->toArray()]);
            
            return response()->json($teams);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des équipes: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération des équipes'], 500);
        }
    }

    /**
     * Add members to a team
     */
    public function addMembers(Request $request, Team $team)
    {
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id'
        ]);

        $team->members()->sync($request->member_ids);

        return back()->with('success', 'Membres de l\'équipe mis à jour avec succès');
    }
}
