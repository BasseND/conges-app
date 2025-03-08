<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Store a newly uploaded document.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'documents.*' => 'required|file|max:10240', // 10MB max
            'document_type' => 'required|string|in:identity,diploma,contract,certificate,other',
            'description' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date|required_if:document_type,identity',
            'status' => 'nullable|string|in:pending,validated,rejected',
        ], [
            'expiration_date.required_if' => 'La date d\'expiration est obligatoire pour les pièces d\'identité.',
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $originalFilename = $file->getClientOriginalName();
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents/' . $user->id, $filename);
                
                // Définir la date d'expiration uniquement pour les pièces d'identité
                $expirationDate = null;
                if ($request->document_type === 'identity') {
                    $expirationDate = $request->expiration_date;
                }
                
                Document::create([
                    'user_id' => $user->id,
                    'uploaded_by' => Auth::id(),
                    'filename' => $originalFilename,
                    'original_filename' => $originalFilename,
                    'file_path' => $path,
                    'type' => $request->document_type,
                    'size' => $file->getSize(),
                    'description' => $request->description,
                    'title' => $request->title,
                    'expiration_date' => $expirationDate,
                    'status' => $request->status ?? 'pending',
                ]);
            }
            
            return redirect()->route('admin.users.show', $user->id)
                ->with('success', 'Document(s) téléchargé(s) avec succès.');
        }
        
        return redirect()->route('admin.users.show', $user->id)
            ->with('error', 'Aucun document n\'a été téléchargé.');
    }

    /**
     * Download a document.
     */
    public function download(User $user, Document $document)
    {
        // Check if the document belongs to the user
        if ($document->user_id !== $user->id) {
            abort(403);
        }
        
        return Storage::download($document->file_path, $document->original_filename);
    }

   /**
     * Delete a document.
     */
    public function destroy(User $user, Document $document)
    {
        // Check if the document belongs to the user
        if ($document->user_id !== $user->id) {
            abort(403);
        }
        
        // Delete the file from storage
        Storage::delete($document->file_path);
        
        // Delete the document record
        $document->delete();
        
        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Document supprimé avec succès.');
    }

    /**
     * Update document status.
     */
    public function updateStatus(Request $request, User $user, Document $document)
    {
        // Vérifier si le document appartient à l'utilisateur
        if ($document->user_id !== $user->id) {
            abort(403);
        }
        
        // Valider les données
        $request->validate([
            'status' => 'required|string|in:pending,validated,rejected',
        ], [
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être l\'un des suivants : En attente, Validé, Rejeté.',
        ]);
        
        // Mettre à jour le statut
        $document->status = $request->status;
        $document->save();
        
        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Statut du document mis à jour avec succès.');
    }
}