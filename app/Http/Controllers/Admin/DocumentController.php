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
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $originalFilename = $file->getClientOriginalName();
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents/' . $user->id, $filename);
                
                Document::create([
                    'user_id' => $user->id,
                    'uploaded_by' => Auth::id(),
                    'filename' => $originalFilename,
                    'original_filename' => $originalFilename,
                    'file_path' => $path,
                    'type' => $request->document_type,
                    'size' => $file->getSize(),
                    'description' => $request->description,
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
}