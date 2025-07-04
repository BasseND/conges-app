<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollSettingController extends Controller
{
    /**
     * Affiche la liste des paramètres de paie.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', PayrollSetting::class);
        
        $payrollSettings = PayrollSetting::paginate(15);
        
        return view('admin.payroll-settings.index', compact('payrollSettings'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau paramètre de paie.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', PayrollSetting::class);
        
        $departments = \App\Models\Department::orderBy('name')->get();
        
        return view('admin.payroll-settings.create', compact('departments'));
    }

    /**
     * Enregistre un nouveau paramètre de paie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', PayrollSetting::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:payroll_settings',
            'description' => 'nullable|string|max:255',
            'value' => 'required|string',
            'type' => 'required|string|in:percentage,amount,text,boolean',
            'is_active' => 'boolean',
            'applies_to' => 'nullable|string|in:all,permanent,temporary,freelance',
        ]);
        
        $payrollSetting = new PayrollSetting();
        $payrollSetting->name = $validated['name'];
        $payrollSetting->description = $validated['description'] ?? null;
        $payrollSetting->value = $validated['value'];
        $payrollSetting->type = $validated['type'];
        $payrollSetting->is_active = $request->has('is_active');
        $payrollSetting->applies_to = $validated['applies_to'] ?? 'all';
        $payrollSetting->created_by = Auth::id();
        $payrollSetting->save();
        
        return redirect()->route('admin.payroll-settings.index')
            ->with('success', 'Le paramètre de paie a été créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un paramètre de paie.
     *
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\View\View
     */
    public function edit(PayrollSetting $payrollSetting)
    {
        $this->authorize('update', $payrollSetting);
        
        return view('admin.payroll-settings.edit', compact('payrollSetting'));
    }

    /**
     * Met à jour un paramètre de paie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PayrollSetting $payrollSetting)
    {
        $this->authorize('update', $payrollSetting);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:payroll_settings,name,' . $payrollSetting->id,
            'description' => 'nullable|string|max:255',
            'value' => 'required|string',
            'type' => 'required|string|in:percentage,amount,text,boolean',
            'is_active' => 'boolean',
            'applies_to' => 'nullable|string|in:all,permanent,temporary,freelance',
        ]);
        
        $payrollSetting->name = $validated['name'];
        $payrollSetting->description = $validated['description'] ?? null;
        $payrollSetting->value = $validated['value'];
        $payrollSetting->type = $validated['type'];
        $payrollSetting->is_active = $request->has('is_active');
        $payrollSetting->applies_to = $validated['applies_to'] ?? 'all';
        $payrollSetting->updated_by = Auth::id();
        $payrollSetting->save();
        
        return redirect()->route('admin.payroll-settings.index')
            ->with('success', 'Le paramètre de paie a été mis à jour avec succès.');
    }

    /**
     * Supprime un paramètre de paie.
     *
     * @param  \App\Models\PayrollSetting  $payrollSetting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PayrollSetting $payrollSetting)
    {
        $this->authorize('delete', $payrollSetting);
        
        $payrollSetting->delete();
        
        return redirect()->route('admin.payroll-settings.index')
            ->with('success', 'Le paramètre de paie a été supprimé avec succès.');
    }
}
