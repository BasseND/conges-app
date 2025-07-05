<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
        
        return view('admin.company.show', compact('company'));
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
            'description' => 'nullable|string',
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
            'description' => 'nullable|string',
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
}