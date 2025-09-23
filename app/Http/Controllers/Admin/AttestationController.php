<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttestationType;
use App\Models\AttestationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttestationController extends Controller
{
    /**
     * Afficher la liste des demandes d'attestations
     */
    public function index(Request $request)
    {
        $query = AttestationRequest::with(['user.department', 'attestationType', 'processor'])
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('attestation_type_id', $request->type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->user . '%')
                  ->orWhere('last_name', 'like', '%' . $request->user . '%');
            });
        }

        $requests = $query->paginate(15);
        $attestationTypes = AttestationType::all();

        // Calculer les statistiques
        $stats = [
            'pending' => AttestationRequest::where('status', AttestationRequest::STATUS_PENDING)->count(),
            'approved' => AttestationRequest::where('status', AttestationRequest::STATUS_APPROVED)->count(),
            'rejected' => AttestationRequest::where('status', AttestationRequest::STATUS_REJECTED)->count(),
            'generated' => AttestationRequest::where('status', AttestationRequest::STATUS_GENERATED)->count(),
        ];

        return view('admin.attestations.index', compact('requests', 'attestationTypes', 'stats'));
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show($id)
    {
        $attestationRequest = AttestationRequest::with(['user.department', 'attestationType', 'processor'])
            ->findOrFail($id);

        // Générer l'aperçu du template avec les variables remplacées
        $templatePreview = null;
        if ($attestationRequest->attestationType->template_file) {
            $pdfService = new \App\Services\AttestationPdfService();
            try {
                $templatePreview = $pdfService->previewContent($attestationRequest);
            } catch (\Exception $e) {
                $templatePreview = 'Erreur lors de la génération de l\'aperçu: ' . $e->getMessage();
            }
        }

        return view('admin.attestations.show', compact('attestationRequest', 'templatePreview'));
    }

    /**
     * Approuver une demande d'attestation
     */
    public function approve($id)
    {
        $attestationRequest = AttestationRequest::findOrFail($id);

        if ($attestationRequest->status !== AttestationRequest::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Cette demande ne peut plus être modifiée.'
            ], 400);
        }

        $attestationRequest->update([
            'status' => AttestationRequest::STATUS_APPROVED,
            'processed_by' => Auth::id(),
            'processed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Demande approuvée avec succès.'
        ]);
    }

    /**
     * Rejeter une demande d'attestation
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $attestationRequest = AttestationRequest::findOrFail($id);

        if ($attestationRequest->status !== AttestationRequest::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Cette demande ne peut plus être modifiée.'
            ], 400);
        }

        $attestationRequest->update([
            'status' => AttestationRequest::STATUS_REJECTED,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Demande rejetée avec succès.'
        ]);
    }

    /**
     * Générer le PDF d'une attestation approuvée
     */
    public function generatePdf($id)
    {
        $attestationRequest = AttestationRequest::with(['user', 'attestationType'])
            ->where('status', AttestationRequest::STATUS_APPROVED)
            ->findOrFail($id);

        try {
            // Utiliser le service AttestationPdfService
            $pdfService = new \App\Services\AttestationPdfService();
            $fileName = $pdfService->generatePdf($attestationRequest);
            $filePath = 'attestations/' . $fileName;

            // Mettre à jour la demande
            $attestationRequest->update([
                'status' => AttestationRequest::STATUS_GENERATED,
                'pdf_path' => $filePath,
                'generated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attestation générée avec succès.',
                'download_url' => route('admin.attestations.download', $attestationRequest->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF: ' . $e->getMessage()
            ], 500);
         }
     }

    /**
     * Télécharger le PDF d'une attestation
     */
    public function download($id)
    {
        $attestationRequest = AttestationRequest::where('status', AttestationRequest::STATUS_GENERATED)
            ->findOrFail($id);

        if (!$attestationRequest->pdf_path || !Storage::disk('public')->exists($attestationRequest->pdf_path)) {
            abort(404, 'Fichier PDF non trouvé.');
        }

        return Storage::disk('public')->download(
            $attestationRequest->pdf_path,
            'attestation_' . $attestationRequest->user->first_name . '_' . $attestationRequest->user->last_name . '.pdf'
        );
    }

    /**
     * Gestion des types d'attestations
     */
    public function types()
    {
        $attestationTypes = AttestationType::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.attestations.types.index', compact('attestationTypes'));
    }

    /**
     * Créer un nouveau type d'attestation
     */
    public function createType()
    {
        return view('admin.attestations.types.create');
    }

    /**
     * Enregistrer un nouveau type d'attestation
     */
    public function storeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attestation_types',
            'system_name' => 'nullable|string|max:255|unique:attestation_types',
            'description' => 'nullable|string|max:1000',
            'template_file' => 'required|string|max:255',
            'type' => 'required|in:salary,presence,employment,custom',
            'status' => 'required|in:active,inactive',
            'requires_date_range' => 'boolean',
            'requires_salary_info' => 'boolean',
            'requires_custom_fields' => 'boolean',
            'custom_fields_config' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AttestationType::create([
            'name' => $request->name,
            'system_name' => $request->system_name,
            'description' => $request->description,
            'template_file' => $request->template_file,
            'type' => $request->type,
            'status' => $request->status,
            'requires_date_range' => $request->boolean('requires_date_range'),
            'requires_salary_info' => $request->boolean('requires_salary_info'),
            'requires_custom_fields' => $request->boolean('requires_custom_fields'),
            'custom_fields_config' => $request->custom_fields_config,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.attestations.types')
            ->with('success', 'Type d\'attestation créé avec succès.');
    }

    /**
     * Éditer un type d'attestation
     */
    public function editType($id)
    {
        $attestationType = AttestationType::findOrFail($id);
        return view('admin.attestations.types.edit', compact('attestationType'));
    }

    /**
     * Mettre à jour un type d'attestation
     */
    public function updateType(Request $request, $id)
    {
        $attestationType = AttestationType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attestation_types,name,' . $id,
            'system_name' => 'nullable|string|max:255|unique:attestation_types,system_name,' . $id,
            'description' => 'nullable|string|max:1000',
            'template_file' => 'required|string|max:255',
            'type' => 'required|in:salary,presence,employment,custom',
            'status' => 'required|in:active,inactive',
            'requires_date_range' => 'boolean',
            'requires_salary_info' => 'boolean',
            'requires_custom_fields' => 'boolean',
            'custom_fields_config' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attestationType->update([
            'name' => $request->name,
            'system_name' => $request->system_name,
            'description' => $request->description,
            'template_file' => $request->template_file,
            'type' => $request->type,
            'status' => $request->status,
            'requires_date_range' => $request->boolean('requires_date_range'),
            'requires_salary_info' => $request->boolean('requires_salary_info'),
            'requires_custom_fields' => $request->boolean('requires_custom_fields'),
            'custom_fields_config' => $request->custom_fields_config,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('admin.attestations.types')
            ->with('success', 'Type d\'attestation mis à jour avec succès.');
    }

    /**
     * Supprimer un type d'attestation
     */
    public function destroyType($id)
    {
        $attestationType = AttestationType::findOrFail($id);

        // Vérifier s'il y a des demandes liées
        if ($attestationType->attestationRequests()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer ce type car il y a des demandes associées.'
            ], 400);
        }

        $attestationType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Type d\'attestation supprimé avec succès.'
        ]);
    }

    /**
     * Obtenir les statistiques des attestations
     */
    public function getStats()
    {
        $stats = [
            'total_requests' => AttestationRequest::count(),
            'pending_requests' => AttestationRequest::pending()->count(),
            'approved_requests' => AttestationRequest::approved()->count(),
            'generated_requests' => AttestationRequest::where('status', AttestationRequest::STATUS_GENERATED)->count(),
            'rejected_requests' => AttestationRequest::where('status', AttestationRequest::STATUS_REJECTED)->count(),
            'total_types' => AttestationType::count(),
            'active_types' => AttestationType::active()->count()
        ];

        return response()->json($stats);
    }


}
