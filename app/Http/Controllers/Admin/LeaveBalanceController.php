<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveBalance;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveBalances = LeaveBalance::with('company')
            ->orderBy('company_id')
            ->orderBy('is_default', 'desc')
            ->paginate(15);
            
        return view('admin.leave-balances.index', compact('leaveBalances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('admin.leave-balances.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'annual_leave_days' => 'required|integer|min:0|max:365',
            'sick_leave_days' => 'required|integer|min:0|max:365',
            'maternity_leave_days' => 'required|integer|min:0|max:365',
            'paternity_leave_days' => 'required|integer|min:0|max:365',
            'special_leave_days' => 'required|integer|min:0|max:365',
            'is_default' => 'boolean',
            'description' => 'nullable|string|max:255'
        ], [
            'company_id.required' => 'L\'entreprise est obligatoire.',
            'company_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'annual_leave_days.required' => 'Le nombre de jours de congés annuels est obligatoire.',
            'annual_leave_days.integer' => 'Le nombre de jours de congés annuels doit être un nombre entier.',
            'annual_leave_days.min' => 'Le nombre de jours de congés annuels ne peut pas être négatif.',
            'annual_leave_days.max' => 'Le nombre de jours de congés annuels ne peut pas dépasser 365.',
            'sick_leave_days.required' => 'Le nombre de jours de congés maladie est obligatoire.',
            'sick_leave_days.integer' => 'Le nombre de jours de congés maladie doit être un nombre entier.',
            'sick_leave_days.min' => 'Le nombre de jours de congés maladie ne peut pas être négatif.',
            'sick_leave_days.max' => 'Le nombre de jours de congés maladie ne peut pas dépasser 365.',
        ]);

        try {
            // Si c'est défini comme défaut, désactiver les autres défauts pour cette entreprise
            if ($request->boolean('is_default')) {
                LeaveBalance::where('company_id', $validatedData['company_id'])
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            LeaveBalance::create($validatedData);

            return redirect()->route('admin.leave-balances.index')
                ->with('success', 'Le solde de congés a été créé avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Error creating leave balance: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['general' => 'Une erreur est survenue lors de la création du solde de congés.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveBalance $leaveBalance)
    {
        $leaveBalance->load('company');
        return view('admin.leave-balances.show', compact('leaveBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveBalance $leaveBalance)
    {
        $companies = Company::orderBy('name')->get();
        return view('admin.leave-balances.edit', compact('leaveBalance', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveBalance $leaveBalance)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'annual_leave_days' => 'required|integer|min:0|max:365',
            'sick_leave_days' => 'required|integer|min:0|max:365',
            'maternity_leave_days' => 'required|integer|min:0|max:365',
            'paternity_leave_days' => 'required|integer|min:0|max:365',
            'special_leave_days' => 'required|integer|min:0|max:365',
            'is_default' => 'boolean',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            // Si c'est défini comme défaut, désactiver les autres défauts pour cette entreprise
            if ($request->boolean('is_default') && !$leaveBalance->is_default) {
                LeaveBalance::where('company_id', $validatedData['company_id'])
                    ->where('id', '!=', $leaveBalance->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            $leaveBalance->update($validatedData);

            return redirect()->route('admin.leave-balances.index')
                ->with('success', 'Le solde de congés a été mis à jour avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Error updating leave balance: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['general' => 'Une erreur est survenue lors de la mise à jour du solde de congés.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveBalance $leaveBalance)
    {
        try {
            // Empêcher la suppression si c'est le solde par défaut et qu'il y a des utilisateurs liés
            if ($leaveBalance->is_default) {
                $usersCount = $leaveBalance->company->users()->count();
                if ($usersCount > 0) {
                    return back()->withErrors(['error' => 'Impossible de supprimer le solde par défaut car il y a des utilisateurs dans cette entreprise.']);
                }
            }

            $leaveBalance->delete();

            return redirect()->route('admin.leave-balances.index')
                ->with('success', 'Le solde de congés a été supprimé avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Error deleting leave balance: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression du solde de congés.']);
        }
    }

    /**
     * Get leave balances for a specific company (AJAX)
     */
    public function getByCompany(Company $company)
    {
        $leaveBalances = $company->leaveBalances()->orderBy('is_default', 'desc')->get();
        return response()->json($leaveBalances);
    }
}