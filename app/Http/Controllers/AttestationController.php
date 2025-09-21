<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttestationType;
use App\Models\AttestationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AttestationController extends Controller
{
    /**
     * Afficher la liste des demandes d'attestations de l'utilisateur connecté
     */
    public function index(Request $request)
    {
        $query = AttestationRequest::with(['attestationType', 'processor'])
            ->forUser(Auth::id())
            ->where('category', 'employee_request')
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('attestation_type_id', $request->type);
        }

        $requests = $query->paginate(10);
        
        $attestationTypes = AttestationType::active()->get();

        return view('attestations.index', compact('requests', 'attestationTypes'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle demande
     */
    public function create()
    {
        $attestationTypes = AttestationType::active()->get();
        
        return view('attestations.create', compact('attestationTypes'));
    }

    /**
     * Récupérer les types d'attestations pour le modal (AJAX)
     */
    public function getTypes()
    {
        $attestationTypes = AttestationType::active()->get();
        
        return response()->json($attestationTypes);
    }

    /**
     * Enregistrer une nouvelle demande d'attestation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'priority' => 'required|in:low,normal,high,urgent',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:1000',
            'custom_data' => 'nullable|array',
            'category' => 'required|in:hr_generated,employee_request'
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier que le type d'attestation est actif
        $attestationType = AttestationType::active()->find($request->attestation_type_id);
        if (!$attestationType) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type d\'attestation non disponible.'
                ], 400);
            }
            return redirect()->back()
                ->with('error', 'Type d\'attestation non disponible.')
                ->withInput();
        }

        // Valider les champs requis selon le type
        if ($attestationType->requires_date_range && (!$request->start_date || !$request->end_date)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce type d\'attestation nécessite une période (date de début et fin).'
                ], 400);
            }
            return redirect()->back()
                ->with('error', 'Ce type d\'attestation nécessite une période (date de début et fin).')
                ->withInput();
        }

        $attestationRequest = AttestationRequest::create([
            'user_id' => Auth::id(),
            'attestation_type_id' => $request->attestation_type_id,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
            'custom_data' => $request->custom_data,
            'category' => $request->category,
            'status' => AttestationRequest::STATUS_PENDING
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre demande d\'attestation a été envoyée avec succès.',
                'data' => $attestationRequest
            ]);
        }

        return redirect()->route('attestations.index')
            ->with('success', 'Votre demande d\'attestation a été envoyée avec succès.');
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show($id)
    {
        $attestationRequest = AttestationRequest::with(['attestationType', 'processor'])
            ->forUser(Auth::id())
            ->where('category', 'employee_request')
            ->findOrFail($id);

        return view('attestations.show', compact('attestationRequest'));
    }

    /**
     * Télécharger le PDF d'une attestation générée
     */
    public function download($id)
    {
        $attestationRequest = AttestationRequest::forUser(Auth::id())
            ->where('status', AttestationRequest::STATUS_GENERATED)
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
     * Annuler une demande en attente
     */
    public function cancel($id)
    {
        $attestationRequest = AttestationRequest::forUser(Auth::id())
            ->where('status', AttestationRequest::STATUS_PENDING)
            ->findOrFail($id);

        $attestationRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Demande annulée avec succès.'
        ]);
    }

    /**
     * Obtenir les statistiques des demandes de l'utilisateur
     */
    public function getStats()
    {
        $userId = Auth::id();
        
        $stats = [
            'total' => AttestationRequest::forUser($userId)->where('category', 'employee_request')->count(),
            'pending' => AttestationRequest::forUser($userId)->where('category', 'employee_request')->pending()->count(),
            'approved' => AttestationRequest::forUser($userId)->where('category', 'employee_request')->approved()->count(),
            'generated' => AttestationRequest::forUser($userId)->where('category', 'employee_request')->where('status', AttestationRequest::STATUS_GENERATED)->count(),
        ];

        return response()->json($stats);
    }
}
