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
    public function index()
    {
        //
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
            'department_id' => 'required|exists:departments,id'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                Team::create($validated);
            });

            return redirect()->back()->with('success', 'Équipe créée avec succès.');
        } catch (\Exception $e) {
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
    public function edit(Team $team)
    {
        return response()->json([
            'name' => $team->name,
            'manager_id' => $team->manager_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager_id' => 'required|exists:users,id'
        ]);

        try {
            DB::transaction(function () use ($team, $validated) {
                $team->update($validated);
            });

            return redirect()->back()->with('success', 'Équipe mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'équipe.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        try {
            if ($team->members()->exists()) {
                return response()->json(['error' => 'Impossible de supprimer une équipe qui contient des membres.'], 422);
            }

            DB::transaction(function () use ($team) {
                $team->delete();
            });

            return response()->json(['success' => 'Équipe supprimée avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'équipe.'], 500);
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
            $teams = $department->teams()->with('manager')->get(['id', 'name', 'manager_id']);
            Log::info('Équipes trouvées: ' . $teams->count(), ['teams' => $teams->toArray()]);
            
            return response()->json($teams);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des équipes: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération des équipes'], 500);
        }
    }
}
