<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialLeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecialLeaveTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,hr']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialLeaveTypes = SpecialLeaveType::orderBy('name')->paginate(15);
        return view('admin.special-leave-types.index', compact('specialLeaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.special-leave-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration_days' => 'required|integer|min:0|max:365',
            'company_id' => 'required|exists:companies,id',
            'seniority_months' => 'nullable|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Le nom du solde de congé est requis.',
            'duration_days.required' => 'Le nombre de jours est requis.',
            'duration_days.min' => 'Le nombre de jours doit être positif ou nul.',
            'duration_days.max' => 'Le nombre de jours ne peut pas dépasser 365.',
            'company_id.required' => 'L\'entreprise est requise.',
            'company_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'seniority_months.min' => 'La condition d\'ancienneté doit être positive ou nulle.',
            'seniority_months.max' => 'La condition d\'ancienneté ne peut pas dépasser 120 mois (10 ans).'
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Créer un solde de congé au lieu d'un type de congé spécial
        $leaveBalanceData = [
            'company_id' => $validated['company_id'],
            'description' => $validated['name'] . ' - ' . ($validated['description'] ?? ''),
            'is_default' => false,
            // Par défaut, on crée un congé spécial
            'annual_leave_days' => 0,
            'maternity_leave_days' => 0,
            'paternity_leave_days' => 0,
            'special_leave_days' => $validated['duration_days']
        ];

        \App\Models\LeaveBalance::create($leaveBalanceData);

        return redirect()->route('admin.company.show')
            ->with('success', 'Solde de congé créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer le type de congé spécial ou le solde de congé
        $specialLeaveType = SpecialLeaveType::find($id);
        
        if ($specialLeaveType) {
            $specialLeaveType->load('leaves.user');
            return view('admin.special-leave-types.show', compact('specialLeaveType'));
        }
        
        // Si ce n'est pas un SpecialLeaveType, essayer de trouver un LeaveBalance
        $leaveBalance = \App\Models\LeaveBalance::find($id);
        
        if (!$leaveBalance) {
            abort(404, 'Type de congé non trouvé');
        }
        
        // Déterminer le type de congé principal
        $leaveType = 'annual';
        if ($leaveBalance->maternity_leave_days > 0) {
            $leaveType = 'maternity';
        } elseif ($leaveBalance->paternity_leave_days > 0) {
            $leaveType = 'paternity';
        } elseif ($leaveBalance->special_leave_days > 0) {
            $leaveType = 'special';
        }
        
        // Créer un objet compatible pour la vue
        $specialLeaveType = (object) [
            'id' => $leaveBalance->id,
            'name' => explode(' - ', $leaveBalance->description)[0] ?? $leaveBalance->description,
            'leave_type' => $leaveType,
            'duration_days' => max($leaveBalance->annual_leave_days, $leaveBalance->maternity_leave_days, $leaveBalance->paternity_leave_days, $leaveBalance->special_leave_days),
            'company_id' => $leaveBalance->company_id,
            'description' => isset(explode(' - ', $leaveBalance->description)[1]) ? explode(' - ', $leaveBalance->description)[1] : '',
            'is_active' => true,
            'seniority_months' => 0,
            'leaves' => collect([]) // Collection vide pour la compatibilité
        ];
        
        return view('admin.special-leave-types.show', compact('specialLeaveType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Récupérer le type de congé spécial ou le solde de congé
        $specialLeaveType = SpecialLeaveType::find($id);
        
        if ($specialLeaveType) {
            return view('admin.special-leave-types.edit', compact('specialLeaveType'));
        }
        
        // Si ce n'est pas un SpecialLeaveType, essayer de trouver un LeaveBalance
        $leaveBalance = \App\Models\LeaveBalance::find($id);
        
        if (!$leaveBalance) {
            abort(404, 'Type de congé non trouvé');
        }
        
        // Déterminer le type de congé principal
        $leaveType = 'annual';
        if ($leaveBalance->maternity_leave_days > 0) {
            $leaveType = 'maternity';
        } elseif ($leaveBalance->paternity_leave_days > 0) {
            $leaveType = 'paternity';
        } elseif ($leaveBalance->special_leave_days > 0) {
            $leaveType = 'special';
        }
        
        // Créer un objet compatible pour la vue
        $specialLeaveType = (object) [
            'id' => $leaveBalance->id,
            'name' => explode(' - ', $leaveBalance->description)[0] ?? $leaveBalance->description,
            'leave_type' => $leaveType,
            'duration_days' => max($leaveBalance->annual_leave_days, $leaveBalance->maternity_leave_days, $leaveBalance->paternity_leave_days, $leaveBalance->special_leave_days),
            'company_id' => $leaveBalance->company_id,
            'description' => isset(explode(' - ', $leaveBalance->description)[1]) ? explode(' - ', $leaveBalance->description)[1] : '',
            'is_active' => true,
            'seniority_months' => 0
        ];
        
        return view('admin.special-leave-types.edit', compact('specialLeaveType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration_days' => 'required|integer|min:0|max:365',
            'company_id' => 'required|exists:companies,id',
            'seniority_months' => 'nullable|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Le nom du solde de congé est requis.',
            'duration_days.required' => 'Le nombre de jours est requis.',
            'duration_days.min' => 'Le nombre de jours doit être positif ou nul.',
            'duration_days.max' => 'Le nombre de jours ne peut pas dépasser 365.',
            'company_id.required' => 'L\'entreprise est requise.',
            'company_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'seniority_months.min' => 'La condition d\'ancienneté doit être positive ou nulle.',
            'seniority_months.max' => 'La condition d\'ancienneté ne peut pas dépasser 120 mois (10 ans).'
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Vérifier si c'est un SpecialLeaveType
        $specialLeaveType = SpecialLeaveType::find($id);
        
        if ($specialLeaveType) {
            // Mettre à jour le type de congé spécial
            $specialLeaveType->update([
                'name' => $validated['name'],
                'duration_days' => $validated['duration_days'],
                'seniority_months' => $validated['seniority_months'] ?? 0,
                'description' => $validated['description'],
                'is_active' => $validated['is_active']
            ]);
            
            return redirect()->route('admin.special-leave-types.show', $specialLeaveType->id)
                ->with('success', 'Type de congé spécial mis à jour avec succès.');
        }
        
        // Si ce n'est pas un SpecialLeaveType, essayer de trouver un LeaveBalance
        $leaveBalance = \App\Models\LeaveBalance::find($id);
        
        if (!$leaveBalance) {
            abort(404, 'Type de congé non trouvé');
        }

        // Préparer les données de mise à jour
        $leaveBalanceData = [
            'company_id' => $validated['company_id'],
            'description' => $validated['name'] . ' - ' . ($validated['description'] ?? ''),
            'is_default' => $leaveBalance->is_default,
            // Conserver le type de congé existant en mettant à jour uniquement la durée
            'annual_leave_days' => $leaveBalance->annual_leave_days > 0 ? $validated['duration_days'] : 0,
            'maternity_leave_days' => $leaveBalance->maternity_leave_days > 0 ? $validated['duration_days'] : 0,
            'paternity_leave_days' => $leaveBalance->paternity_leave_days > 0 ? $validated['duration_days'] : 0,
            'special_leave_days' => $leaveBalance->special_leave_days > 0 ? $validated['duration_days'] : 0
        ];
        
        // Si aucun type n'est défini, on utilise le type spécial par défaut
         if ($leaveBalanceData['annual_leave_days'] == 0 && 
             $leaveBalanceData['maternity_leave_days'] == 0 && 
             $leaveBalanceData['paternity_leave_days'] == 0 && 
             $leaveBalanceData['special_leave_days'] == 0) {
             $leaveBalanceData['special_leave_days'] = $validated['duration_days'];
         }

        $leaveBalance->update($leaveBalanceData);

        return redirect()->route('admin.special-leave-types.show', $leaveBalance->id)
            ->with('success', 'Solde de congé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Vérifier si c'est un SpecialLeaveType
        $specialLeaveType = SpecialLeaveType::find($id);
        
        if ($specialLeaveType) {
            // Vérifier si des congés sont associés à ce type
            if ($specialLeaveType->leaves()->count() > 0) {
                return redirect()->route('admin.special-leave-types.index')
                    ->with('error', 'Impossible de supprimer ce type de congé car des demandes y sont associées.');
            }
            
            // Vérifier si c'est un type de congé par défaut
            if (in_array($specialLeaveType->system_name, ['conge_annuel', 'conge_maternite', 'conge_paternite', 'conge_maladie'])) {
                return redirect()->route('admin.special-leave-types.index')
                    ->with('error', 'Impossible de supprimer un type de congé par défaut.');
            }
            
            $specialLeaveType->delete();
            
            return redirect()->route('admin.special-leave-types.index')
                ->with('success', 'Type de congé spécial supprimé avec succès.');
        }
        
        // Si ce n'est pas un SpecialLeaveType, essayer de trouver un LeaveBalance
        $leaveBalance = \App\Models\LeaveBalance::find($id);
        
        if (!$leaveBalance) {
            abort(404, 'Type de congé non trouvé');
        }
        
        // Vérifier si des utilisateurs sont associés à ce solde
        if ($leaveBalance->users()->count() > 0) {
            return redirect()->route('admin.special-leave-types.index')
                ->with('error', 'Impossible de supprimer ce solde de congé car des utilisateurs y sont associés.');
        }
        
        // Vérifier si c'est un solde par défaut
        if ($leaveBalance->is_default) {
            return redirect()->route('admin.special-leave-types.index')
                ->with('error', 'Impossible de supprimer un solde de congé par défaut.');
        }

        $leaveBalance->delete();

        return redirect()->route('admin.special-leave-types.index')
            ->with('success', 'Solde de congé supprimé avec succès.');
    }
}
