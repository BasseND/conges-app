<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'type' => ['required', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after:date_debut'],
            'salaire_brut' => ['required', 'numeric', 'min:0'],
            'statut' => ['required', Rule::in(['actif', 'termine', 'suspendu'])],
            'contrat_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
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
        
        // Valider les données
        $validated = $request->validate([
            'type' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'salaire_brut' => 'required|numeric|min:0',
            'statut' => 'required|string|in:actif,suspendu,termine',
        ]);
        
        // Mettre à jour le contrat
        $contract->type = $validated['type'];
        $contract->date_debut = $validated['date_debut'];
        $contract->date_fin = $validated['date_fin'];
        $contract->salaire_brut = $validated['salaire_brut'];
        $contract->statut = $validated['statut'];
        
        // Gérer le fichier si fourni
        if ($request->hasFile('contrat_file')) {
            // Supprimer l'ancien fichier si existant
            if ($contract->contrat_file) {
                Storage::delete($contract->contrat_file);
            }
            
            // Stocker le nouveau fichier
            $path = $request->file('contrat_file')->store('contracts');
            $contract->contrat_file = $path;
            $contract->original_filename = $request->file('contrat_file')->getClientOriginalName();
        }
        
        $contract->save();
        
        return redirect()->route('admin.users.show', $user->id)
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
