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
        $this->middleware(['auth', 'role:admin,hr_admin,hr']);
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
        // Récupérer automatiquement l'ID de l'entreprise
        $company = \App\Models\Company::first();
        if (!$company) {
            return redirect()->back()->withErrors(['company' => 'Aucune entreprise configurée dans le système.']);
        }

        // Vérifier l'unicité du nom manuellement
        $existingType = SpecialLeaveType::where('name', $request->name)
                                       ->where('company_id', $company->id)
                                       ->first();
        
        if ($existingType) {
            return redirect()->back()
                           ->withErrors(['name' => 'Un type de congé avec ce nom existe déjà dans votre entreprise.'])
                           ->withInput();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:systeme,custom',
            'has_balance' => 'sometimes|boolean',
            'duration_days' => [\Illuminate\Validation\Rule::requiredIf($request->boolean('has_balance')), 'integer', 'min:0', 'max:365'],
            'seniority_months' => 'nullable|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Le nom du type de congé est requis.',
            'type.required' => 'Le type est requis.',
            'type.in' => 'Le type doit être "système" ou "custom".',
            'duration_days.required' => 'Le nombre de jours est requis lorsque le solde est limité.',
            'duration_days.min' => 'Le nombre de jours doit être positif ou nul.',
            'duration_days.max' => 'Le nombre de jours ne peut pas dépasser 365.',
            'seniority_months.min' => 'La condition d\'ancienneté doit être positive ou nulle.',
            'seniority_months.max' => 'La condition d\'ancienneté ne peut pas dépasser 120 mois (10 ans).'
        ]);

        $validated['company_id'] = $company->id;
        $validated['is_active'] = $request->has('is_active');
        $validated['has_balance'] = $request->boolean('has_balance');
        $validated['seniority_months'] = $validated['seniority_months'] ?? 0;

        // Si le type est illimité (sans solde), forcer la durée à 0
        if (!$validated['has_balance']) {
            $validated['duration_days'] = 0;
        }

        SpecialLeaveType::create($validated);

        return redirect()->route('admin.company.show')
            ->with('success', 'Type de congé spécial créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $specialLeaveType = SpecialLeaveType::findOrFail($id);
        $specialLeaveType->load('leaves.user');
        
        return view('admin.special-leave-types.show', compact('specialLeaveType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $specialLeaveType = SpecialLeaveType::findOrFail($id);

        return view('admin.special-leave-types.edit', compact('specialLeaveType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $specialLeaveType = SpecialLeaveType::findOrFail($id);

        // Récupérer automatiquement l'ID de l'entreprise
        $company = \App\Models\Company::first();
        if (!$company) {
            return redirect()->back()->withErrors(['company' => 'Aucune entreprise configurée dans le système.']);
        }

        // Vérifier l'unicité du nom manuellement (en excluant l'enregistrement actuel)
        $existingType = SpecialLeaveType::where('name', $request->name)
                                       ->where('company_id', $company->id)
                                       ->where('id', '!=', $id)
                                       ->first();
        
        if ($existingType) {
            return redirect()->back()
                           ->withErrors(['name' => 'Un type de congé avec ce nom existe déjà dans votre entreprise.'])
                           ->withInput();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:systeme,custom',
            'has_balance' => 'sometimes|boolean',
            'duration_days' => [\Illuminate\Validation\Rule::requiredIf($request->boolean('has_balance')), 'integer', 'min:0', 'max:365'],
            'seniority_months' => 'nullable|integer|min:0|max:120',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Le nom du type de congé est requis.',
            'type.required' => 'Le type est requis.',
            'type.in' => 'Le type doit être "système" ou "custom".',
            'duration_days.required' => 'Le nombre de jours est requis lorsque le solde est limité.',
            'duration_days.min' => 'Le nombre de jours doit être positif ou nul.',
            'duration_days.max' => 'Le nombre de jours ne peut pas dépasser 365.',
            'seniority_months.min' => 'La condition d\'ancienneté doit être positive ou nulle.',
            'seniority_months.max' => 'La condition d\'ancienneté ne peut pas dépasser 120 mois (10 ans).'
        ]);

        $validated['company_id'] = $company->id;
        $validated['is_active'] = $request->has('is_active');
        $validated['has_balance'] = $request->boolean('has_balance');
        $validated['seniority_months'] = $validated['seniority_months'] ?? 0;

        // Si le type est illimité (sans solde), forcer la durée à 0
        if (!$validated['has_balance']) {
            $validated['duration_days'] = 0;
        }

        $specialLeaveType = SpecialLeaveType::findOrFail($id);
        $specialLeaveType->update($validated);
        
        return redirect()->route('admin.special-leave-types.show', $specialLeaveType->id)
            ->with('success', 'Type de congé spécial mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $specialLeaveType = SpecialLeaveType::findOrFail($id);
        
        // Vérifier si des congés sont associés à ce type
        if ($specialLeaveType->leaves()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce type de congé car des demandes y sont associées.'
                ], 422);
            }
            return redirect()->route('admin.special-leave-types.index')
                ->with('error', 'Impossible de supprimer ce type de congé car des demandes y sont associées.');
        }
        
        // Vérifier si c'est un type de congé système
        if ($specialLeaveType->type === 'systeme') {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer un type de congé système.'
                ], 422);
            }
            return redirect()->route('admin.special-leave-types.index')
                ->with('error', 'Impossible de supprimer un type de congé système.');
        }
        
        $specialLeaveType->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Type de congé spécial supprimé avec succès.'
            ]);
        }
        
        return redirect()->route('admin.company.show')
            ->with('success', 'Type de congé spécial supprimé avec succès.');
    }
}
