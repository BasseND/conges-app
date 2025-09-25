<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\ContractType;
use App\Models\SpecialLeaveType;
// LeaveBalance supprimé - remplacé par SpecialLeaveType
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Afficher les informations de la société
     */
    public function show()
    {
        // Eager loading sélectif pour la société avec ses relations
        $company = Company::with([
            'contractTypes:id,company_id,name,description,is_active',
            'specialLeaveTypes:id,company_id,name,description,is_active,type,duration_days,seniority_months'
        ])->first();
        
        // Optimiser la récupération des types de congés spéciaux avec toutes les colonnes nécessaires
        // Récupérer à la fois les types système (company_id = null) et les types spécifiques à la société
        $specialLeaveTypes = $company ? 
            SpecialLeaveType::where(function($query) use ($company) {
                $query->whereNull('company_id') // Types système
                      ->orWhere('company_id', $company->id); // Types spécifiques à la société
            })
            ->select('id', 'company_id', 'name', 'description', 'is_active', 'type', 'duration_days', 'seniority_months')
            ->orderBy('name')
            ->get() : 
            SpecialLeaveType::select('id', 'company_id', 'name', 'description', 'is_active', 'type', 'duration_days', 'seniority_months')
                ->orderBy('name')
                ->get();
        
        // Optimiser la récupération des types de contrats
        $contractTypes = $company ? 
            $company->contractTypes()->select('id', 'company_id', 'name', 'description', 'is_active')->orderBy('name')->get() : 
            collect();
        
        return view('admin.company.show', compact('company', 'specialLeaveTypes', 'contractTypes'));
    }

    /**
     * Afficher le formulaire d'édition des informations de la société
     */
    public function edit()
    {
        $company = Company::first();
        
        return view('admin.company.edit', compact('company'));
    }

    /**
     * Mettre à jour les informations de la société
     */
    public function update(Request $request)
    {
        $company = Company::first();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:10',
            'salary_advance_deadline_day' => 'nullable|integer|min:1|max:31',
            'director_name' => 'nullable|string|max:255',
            'hr_director_name' => 'nullable|string|max:255',
            'hr_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo', 'hr_signature']);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($company && $company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }

            // Stocker le nouveau logo
            $logoPath = $request->file('logo')->store('company/logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Gestion de la signature du DRH
        if ($request->hasFile('hr_signature')) {
            // Supprimer l'ancienne signature s'il existe
            if ($company && $company->hr_signature && Storage::disk('public')->exists($company->hr_signature)) {
                Storage::disk('public')->delete($company->hr_signature);
            }

            // Stocker la nouvelle signature
            $signaturePath = $request->file('hr_signature')->store('company/signatures', 'public');
            $data['hr_signature'] = $signaturePath;
        }

        if ($company) {
            // Mettre à jour la société existante
            $company->update($data);
            $message = 'Les informations de la société ont été mises à jour avec succès.';
        } else {
            // Créer une nouvelle société
            Company::create($data);
            $message = 'Les informations de la société ont été créées avec succès.';
        }

        return redirect()->route('admin.company.show')
            ->with('success', $message);
    }

    /**
     * Créer les informations de la société si elles n'existent pas
     */
    public function create()
    {
        $company = Company::first();
        
        if ($company) {
            return redirect()->route('admin.company.edit');
        }
        
        return view('admin.company.create');
    }

    /**
     * Stocker les nouvelles informations de la société
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:10',
            'director_name' => 'nullable|string|max:255',
            'hr_director_name' => 'nullable|string|max:255',
            'hr_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo', 'hr_signature']);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company/logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Gestion de la signature du DRH
        if ($request->hasFile('hr_signature')) {
            $signaturePath = $request->file('hr_signature')->store('company/signatures', 'public');
            $data['hr_signature'] = $signaturePath;
        }

        Company::create($data);

        return redirect()->route('admin.company.show')
            ->with('success', 'Les informations de la société ont été créées avec succès.');
    }

    /**
     * Stocker les types de contrats pour la société
     */
    public function storeContractTypes(Request $request)
    {
        $company = Company::first();
        
        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune société trouvée. Veuillez d\'abord créer les informations de la société.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'contract_types' => 'required|array|min:1',
            'contract_types.*.name' => 'required|string|max:255',
            'contract_types.*.system_name' => 'nullable|string|max:255',
            'contract_types.*.description' => 'nullable|string|max:1000',
            'contract_types.*.is_active' => 'boolean',
        ], [
            'contract_types.required' => 'Au moins un type de contrat est requis.',
            'contract_types.*.name.required' => 'Le nom du type de contrat est obligatoire.',
            'contract_types.*.name.max' => 'Le nom du type de contrat ne peut pas dépasser 255 caractères.',
            'contract_types.*.system_name.max' => 'Le nom système ne peut pas dépasser 255 caractères.',
            'contract_types.*.description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $contractTypesData = $request->input('contract_types');
            $createdCount = 0;

            foreach ($contractTypesData as $contractTypeData) {
                $name = trim($contractTypeData['name']);
                
                // Vérifier si un type avec le même nom existe déjà pour cette société
                if (ContractType::nameExists($name, $company->id)) {
                    continue; // Passer au suivant si le nom existe déjà
                }
                
                // Générer ou utiliser le system_name fourni
                $systemName = isset($contractTypeData['system_name']) && !empty(trim($contractTypeData['system_name']))
                    ? trim($contractTypeData['system_name'])
                    : ContractType::generateSystemName($name, $company->id);
                
                // Vérifier l'unicité du system_name
                if (ContractType::systemNameExists($systemName, $company->id)) {
                    $systemName = ContractType::generateSystemName($name, $company->id);
                }

                ContractType::create([
                    'company_id' => $company->id,
                    'name' => $name,
                    'system_name' => $systemName,
                    'description' => isset($contractTypeData['description']) ? trim($contractTypeData['description']) : null,
                    'is_active' => isset($contractTypeData['is_active']) ? (bool)$contractTypeData['is_active'] : true,
                ]);
                $createdCount++;
            }

            DB::commit();

            if ($createdCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun nouveau type de contrat n\'a été créé. Tous les types existent déjà.'
                ]);
            }

            $message = $createdCount === 1 
                ? '1 type de contrat a été créé avec succès.' 
                : "{$createdCount} types de contrats ont été créés avec succès.";

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement des types de contrats.'
            ], 500);
        }
    }

    /**
     * Mettre à jour un type de contrat existant
     */
    public function updateContractType(Request $request, ContractType $contractType)
    {
        $company = Company::first();
        
        if (!$company || $contractType->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'Type de contrat non trouvé ou non autorisé.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Le nom du type de contrat est obligatoire.',
            'name.max' => 'Le nom du type de contrat ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreurs de validation.',
                'errors' => $validator->errors()
            ], 422);
        }

        $name = trim($request->input('name'));
        
        // Vérifier l'unicité du nom (exclure l'enregistrement actuel)
        if (ContractType::nameExists($name, $company->id, $contractType->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Un type de contrat avec ce nom existe déjà.'
            ], 422);
        }

        try {
            $contractType->update([
                'name' => $name,
                'description' => $request->input('description'),
                'is_active' => $request->boolean('is_active', true),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Le type de contrat a été mis à jour avec succès.',
                'contract_type' => $contractType->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du type de contrat.'
            ], 500);
        }
    }

    // Méthodes LeaveBalance supprimées - remplacées par SpecialLeaveType
}