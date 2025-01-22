<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Log::info('Création d\'une nouvelle équipe');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'manager_id' => 'required|exists:users,id',
        ]);

        $team = Team::create($request->all());
        Log::info('Équipe créée avec succès', ['team' => $team->toArray()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Équipe créée avec succès',
            'team' => $team
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        Log::info('Mise à jour de l\'équipe: ' . $team->id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'manager_id' => 'required|exists:users,id',
        ]);

        $team->update($request->all());
        Log::info('Équipe mise à jour avec succès', ['team' => $team->toArray()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Équipe mise à jour avec succès',
            'team' => $team
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        Log::info('Suppression de l\'équipe: ' . $team->id);
        
        $team->delete();
        Log::info('Équipe supprimée avec succès');

        return response()->json([
            'status' => 'success',
            'message' => 'Équipe supprimée avec succès'
        ]);
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
