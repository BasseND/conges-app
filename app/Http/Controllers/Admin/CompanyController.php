<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
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
        $company = Company::first();
        $leaveBalances = $company ? $company->leaveBalances()->orderBy('is_default', 'desc')->orderBy('description')->get() : collect();
        
        return view('admin.company.show', compact('company', 'leaveBalances'));
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo']);

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['logo']);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company/logos', 'public');
            $data['logo'] = $logoPath;
        }

        Company::create($data);

        return redirect()->route('admin.company.show')
            ->with('success', 'Les informations de la société ont été créées avec succès.');
    }

    /**
     * Stocker un nouveau solde de congés
     */
    public function storeLeaveBalance(Request $request)
    {
        $company = Company::first();
        
        if (!$company) {
            return response()->json(['error' => 'Aucune société configurée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'annual_leave_days' => 'required|integer|min:0|max:365',
            'maternity_leave_days' => 'nullable|integer|min:0|max:365',
            'paternity_leave_days' => 'nullable|integer|min:0|max:365',
            'special_leave_days' => 'nullable|integer|min:0|max:365',
            'is_default' => 'boolean',
            'description' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['company_id'] = $company->id;
        
        // Si c'est défini comme défaut, retirer le statut défaut des autres
        if ($request->boolean('is_default')) {
            LeaveBalance::where('company_id', $company->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $leaveBalance = LeaveBalance::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Solde de congés créé avec succès',
            'leaveBalance' => $leaveBalance
        ]);
    }

    /**
     * Mettre à jour un solde de congés
     */
    public function updateLeaveBalance(Request $request, LeaveBalance $leaveBalance)
    {
        $company = Company::first();
        
        if (!$company || $leaveBalance->company_id !== $company->id) {
            return response()->json(['error' => 'Solde de congés non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'annual_leave_days' => 'required|integer|min:0|max:365',
            'maternity_leave_days' => 'nullable|integer|min:0|max:365',
            'paternity_leave_days' => 'nullable|integer|min:0|max:365',
            'special_leave_days' => 'nullable|integer|min:0|max:365',
            'is_default' => 'boolean',
            'description' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Si c'est défini comme défaut, retirer le statut défaut des autres
        if ($request->boolean('is_default') && !$leaveBalance->is_default) {
            LeaveBalance::where('company_id', $company->id)
                ->where('id', '!=', $leaveBalance->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $leaveBalance->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Solde de congés mis à jour avec succès',
            'leaveBalance' => $leaveBalance
        ]);
    }

    /**
     * Supprimer un solde de congés
     */
    public function destroyLeaveBalance(LeaveBalance $leaveBalance)
    {
        $company = Company::first();
        
        if (!$company || $leaveBalance->company_id !== $company->id) {
            return response()->json(['error' => 'Solde de congés non trouvé'], 404);
        }

        // Vérifier si des utilisateurs utilisent ce solde
        $usersCount = $leaveBalance->users()->count();
        if ($usersCount > 0) {
            return response()->json([
                'error' => "Ce solde de congés ne peut pas être supprimé car il est utilisé par {$usersCount} utilisateur(s)"
            ], 422);
        }

        $leaveBalance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Solde de congés supprimé avec succès'
        ]);
    }
}