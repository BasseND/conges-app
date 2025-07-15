<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use App\Models\Company;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    /**
     * Display a listing of all contracts.
     */
    public function index()
    {
        $contracts = Contract::with(['user'])
            ->orderBy('date_fin', 'asc')
            ->paginate(10);

        // Récupérer la devise de l'entreprise
        $company = Company::first();
        $globalCompanyCurrency = $company ? $company->currency : '€';

        return view('admin.contracts.index', compact('contracts', 'globalCompanyCurrency'));
    }

    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request, User $user)
    {
        // Définir les règles de base
        $rules = [
            'type' => ['required', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after:date_debut'],
            'statut' => ['required', Rule::in(['actif', 'termine', 'suspendu'])],
            'contrat_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ];

        // Ajout des règles conditionnelles selon le type de contrat
        if ($request->type === 'Freelance') {
            $rules['tjm'] = ['required', 'numeric', 'min:0'];
            $rules['salaire_brut'] = ['nullable', 'numeric', 'min:0'];
        } else {
            $rules['salaire_brut'] = ['required', 'numeric', 'min:0'];
            $rules['tjm'] = ['nullable', 'numeric', 'min:0'];
        }

        // Valider les données avec toutes les règles
        $validated = $request->validate($rules, [
            'type.required' => 'Le type de contrat est obligatoire.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after' => 'La date de fin doit être postérieure à la date de début.',
            'statut.required' => 'Le statut du contrat est obligatoire.',
            'statut.in' => 'Le statut du contrat doit être actif, terminé ou suspendu.',
            'salaire_brut.required' => 'Le salaire brut est obligatoire.',
            'salaire_brut.numeric' => 'Le salaire brut doit être un nombre.',
            'salaire_brut.min' => 'Le salaire brut doit être supérieur ou égal à 0.',
            'tjm.required' => 'Le taux journalier est obligatoire pour les freelances.',
            'tjm.numeric' => 'Le taux journalier doit être un nombre.',
            'tjm.min' => 'Le taux journalier doit être supérieur ou égal à 0.',
            'contrat_file.file' => 'Le fichier du contrat doit être un fichier valide.',
            'contrat_file.mimes' => 'Le fichier du contrat doit être au format PDF, DOC ou DOCX.',
            'contrat_file.max' => 'Le fichier du contrat ne doit pas dépasser 10 Mo.',
        ]);

        if ($request->hasFile('contrat_file')) {
            $path = $request->file('contrat_file')->store('contrats');
            $validated['contrat_file'] = $path;
        }

        $contract = $user->contracts()->create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contrat créé avec succès.',
                'contract' => $contract
            ]);
        }

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Contrat créé avec succès.');
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract)
    {
        return response()->json([
            'id' => $contract->id,
            'type' => $contract->type,
            'date_debut' => $contract->date_debut->format('Y-m-d'),
            'date_fin' => $contract->date_fin ? $contract->date_fin->format('Y-m-d') : null,
            'salaire_brut' => $contract->salaire_brut,
            'tjm' => $contract->tjm,
            'statut' => $contract->statut,
            'user_id' => $contract->user_id
        ]);
    }

    /**
     * Show the form for editing the specified contract.
     */
   
    public function edit(User $user, Contract $contract)
    {
        // Vérifier les permissions
        if ($contract->user_id !== $user->id) {
            abort(403);
        }
        
        return response()->json([
            'type' => $contract->type,
            'date_debut' => $contract->date_debut->format('Y-m-d'),
            'date_fin' => $contract->date_fin ? $contract->date_fin->format('Y-m-d') : null,
            'salaire_brut' => $contract->salaire_brut,
            'tjm' => $contract->tjm,
            'statut' => $contract->statut,
        ]);
    }

    /**
     * Update the specified contract in storage.
     */

     public function update(Request $request, User $user, Contract $contract)
     {
         // Vérifier les permissions
         if ($contract->user_id !== $user->id) {
             abort(403);
         }
         
         // Règles de validation de base - sans le type qui ne peut pas être modifié
         $rules = [
             'date_debut' => 'required|date',
             'date_fin' => 'nullable|date|after:date_debut',
             'statut' => 'required|string|in:actif,suspendu,termine',
         ];
         
         // Ajout des règles conditionnelles selon le type de contrat existant
         if ($contract->type === 'Freelance') {
             $rules['tjm'] = 'required|numeric|min:0';
             $rules['salaire_brut'] = 'nullable|numeric|min:0';
         } else {
             $rules['salaire_brut'] = 'required|numeric|min:0';
             $rules['tjm'] = 'nullable|numeric|min:0';
         }
         
         // Valider les données
         $validated = $request->validate($rules);
         
         // Mettre à jour le contrat - sans modifier le type
         $contract->date_debut = $validated['date_debut'];
         $contract->date_fin = $validated['date_fin'] ?? null;
         $contract->statut = $validated['statut'];
         
         // Mettre à jour les champs financiers selon le type de contrat existant
         if ($contract->type === 'Freelance') {
             $contract->tjm = $validated['tjm'];
             $contract->salaire_brut = 0; // Valeur par défaut pour les freelances
         } else {
             $contract->salaire_brut = $validated['salaire_brut'];
             $contract->tjm = 0; // Valeur par défaut pour les non-freelances
         }
         
         // Gérer le fichier si fourni
         if ($request->hasFile('contrat_file')) {
             // Supprimer l'ancien fichier si existant
             if ($contract->contrat_file) {
                 Storage::delete($contract->contrat_file);
             }
             
             // Stocker le nouveau fichier
             $path = $request->file('contrat_file')->store('contracts');
             $contract->contrat_file = $path;
             
         }
         
         $contract->save();
         
         // Créer une notification pour la modification du contrat
         $notificationService = app(NotificationService::class);
         $notificationService->createContractUpdatedNotification($contract);
         
         if ($request->ajax() || $request->wantsJson()) {
             return response()->json([
                 'success' => true,
                 'message' => 'Contrat mis à jour avec succès.',
                 'contract' => $contract
             ]);
         }

         return redirect()->route('admin.users.show', $user->id)
             ->with('success', 'Contrat mis à jour avec succès.');
     }

    /**
     * Update the specified contract in storage (global route).
     */
    public function updateContract(Request $request, Contract $contract)
    {
        // Règles de validation de base
        $rules = [
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'statut' => 'required|string|in:actif,suspendu,termine',
        ];
        
        // Ajout des règles conditionnelles selon le type de contrat existant
        if ($contract->type === 'Freelance') {
            $rules['tjm'] = 'required|numeric|min:0';
            $rules['salaire_brut'] = 'nullable|numeric|min:0';
        } else {
            $rules['salaire_brut'] = 'required|numeric|min:0';
            $rules['tjm'] = 'nullable|numeric|min:0';
        }
        
        // Valider les données
        $validated = $request->validate($rules);
        
        // Mettre à jour le contrat
        $contract->date_debut = $validated['date_debut'];
        $contract->date_fin = $validated['date_fin'] ?? null;
        $contract->statut = $validated['statut'];
        
        // Mettre à jour les champs financiers selon le type de contrat existant
        if ($contract->type === 'Freelance') {
            $contract->tjm = $validated['tjm'];
            $contract->salaire_brut = 0;
        } else {
            $contract->salaire_brut = $validated['salaire_brut'];
            $contract->tjm = 0;
        }
        
        // Gérer le fichier si fourni
        if ($request->hasFile('contrat_file')) {
            // Supprimer l'ancien fichier si existant
            if ($contract->contrat_file) {
                Storage::delete($contract->contrat_file);
            }
            
            // Stocker le nouveau fichier
            $path = $request->file('contrat_file')->store('contracts');
            $contract->contrat_file = $path;
        }
        
        $contract->save();
        
        // Créer une notification pour la modification du contrat
        $notificationService = app(NotificationService::class);
        $notificationService->createContractUpdatedNotification($contract);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contrat mis à jour avec succès.',
                'contract' => $contract
            ]);
        }
        
        return redirect()->route('admin.contracts.index')
            ->with('success', 'Contrat mis à jour avec succès.');
    }

    /**
     * Remove the specified contract from storage.
     */
    public function destroy(User $user, Contract $contract)
    {
        $this->authorize('delete', $contract);

        if ($contract->contrat_file) {
            Storage::delete($contract->contrat_file);
        }

        $contract->delete();

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Contrat supprimé avec succès.');
    }

    /**
     * Download the contract file.
     */
    public function download(Contract $contract)
    {
        $this->authorize('view', $contract);

        if (!$contract->contrat_file || !Storage::exists($contract->contrat_file)) {
            return back()->with('error', 'Le fichier du contrat n\'existe pas.');
        }

        return Storage::download($contract->contrat_file);
    }
}
