<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttestationRequest;
use App\Models\AttestationType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class HrAttestationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, ['admin', 'hr'])) {
                abort(403, 'Accès non autorisé. Cette fonctionnalité est réservée aux RH.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pagination flexible
        $perPage = $request->get('per_page', 50);
        $perPage = in_array($perPage, [25, 50, 100]) ? $perPage : 50;

        // Eager loading sélectif avec colonnes spécifiques
        $query = AttestationRequest::with([
                'user:id,first_name,last_name,email,employee_id,department_id',
                'user.department:id,name',
                'attestationType:id,name,type',
                'generator:id,first_name,last_name'
            ])
            ->whereNotNull('generated_by')
            ->orderBy('created_at', 'desc');

        // Recherche globale par nom d'employé ou matricule
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtres existants (compatibilité)
        if ($request->filled('user_search')) {
            $search = $request->user_search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type_id')) {
            $query->where('attestation_type_id', $request->type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('generated_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('generated_at', '<=', $request->date_to);
        }

        $attestations = $query->paginate($perPage)->appends($request->query());
        $attestationTypes = AttestationType::whereIn('type', ['salary', 'employment', 'presence'])->get();
        $statuses = [
            'draft' => 'Brouillon',
            'generated' => 'Générée',
            'sent' => 'Envoyée',
            'archived' => 'Archivée'
        ];

        return view('admin.hr-attestations.index', compact('attestations', 'attestationTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attestationTypes = AttestationType::where('status', 'active')->get();
        return view('admin.hr-attestations.create', compact('attestationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'custom_data' => 'nullable|array',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'presence_start_date' => 'nullable|date',
            'presence_end_date' => 'nullable|date|after_or_equal:presence_start_date',
            'notes' => 'nullable|string|max:1000',
            'category' => 'required|in:hr_generated,employee_request'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier que le type d'attestation est actif
        $attestationType = AttestationType::active()->find($request->attestation_type_id);
        if (!$attestationType) {
            return redirect()->back()
                ->with('error', 'Type d\'attestation non disponible.')
                ->withInput();
        }

        // Valider les champs requis selon le type
        if ($attestationType->requires_date_range) {
            // Pour l'attestation de présence, vérifier les champs spécifiques
            if ($attestationType->name === 'Attestation de présence / assiduité') {
                if (!$request->presence_start_date || !$request->presence_end_date) {
                    return redirect()->back()
                        ->with('error', 'L\'attestation de présence nécessite une période (date de début et fin de présence).')
                        ->withInput();
                }
            } else {
                // Pour les autres types d'attestation
                if (!$request->start_date || !$request->end_date) {
                    return redirect()->back()
                        ->with('error', 'Ce type d\'attestation nécessite une période (date de début et fin).')
                        ->withInput();
                }
            }
        }

        try {
            // Générer un numéro de document unique
            $documentNumber = 'ATT-' . date('Y') . '-' . str_pad(AttestationRequest::whereYear('created_at', date('Y'))->count() + 1, 4, '0', STR_PAD_LEFT);

            // Préparer les données personnalisées
            $customData = $request->custom_data ?? [];
            
            // Traiter les champs spécifiques à l'attestation de présence
            if ($request->presence_start_date) {
                $customData['date_debut_periode'] = $request->presence_start_date;
            }
            if ($request->presence_end_date) {
                $customData['date_fin_periode'] = $request->presence_end_date;
            }

            $attestation = AttestationRequest::create([
                'user_id' => $request->user_id,
                'attestation_type_id' => $request->attestation_type_id,
                'category' => $request->category,
                'generated_by' => Auth::id(),
                'processed_by' => Auth::id(),
                'status' => AttestationRequest::STATUS_GENERATED,
                'priority' => AttestationRequest::PRIORITY_NORMAL,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'custom_data' => $customData,
                'notes' => $request->notes,
                'document_number' => $documentNumber,
                'processed_at' => now(),
                'generated_at' => now()
            ]);

            // Tenter de générer le PDF, mais ne pas échouer si ça ne marche pas
            try {
                $this->generatePdf($attestation);
                $attestation->update(['status' => AttestationRequest::STATUS_GENERATED]);
            } catch (\Exception $pdfError) {
                // Log l'erreur PDF mais continue
                \Log::error('Erreur génération PDF pour attestation ' . $attestation->id . ': ' . $pdfError->getMessage());
                $attestation->update(['status' => 'pending', 'notes' => ($attestation->notes ? $attestation->notes . '\n' : '') . 'Erreur PDF: ' . $pdfError->getMessage()]);
            }

            return redirect()->route('admin.hr-attestations.index')
                ->with('success', 'Attestation générée avec succès pour ' . $attestation->user->first_name . ' ' . $attestation->user->last_name . '!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la génération de l\'attestation: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttestationRequest $attestationRequest)
    {
        $attestationRequest->load(['user.department', 'attestationType', 'generator']);
        return view('admin.hr-attestations.show', compact('attestationRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttestationRequest $attestationRequest)
    {
        $attestationRequest->load(['user', 'attestationType']);
        $attestationTypes = AttestationType::where('status', 'active')->get();
        return view('admin.hr-attestations.edit', compact('attestationRequest', 'attestationTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttestationRequest $attestationRequest)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'custom_data' => 'nullable|array',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:1000',
            'category' => 'required|in:hr_generated,employee_request'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Supprimer l'ancien PDF si il existe
            if ($attestationRequest->pdf_path && Storage::exists($attestationRequest->pdf_path)) {
                Storage::delete($attestationRequest->pdf_path);
            }

            // Mettre à jour l'attestation
            $attestationRequest->update([
                'user_id' => $request->user_id,
                'attestation_type_id' => $request->attestation_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'custom_data' => $request->custom_data ?? [],
                'notes' => $request->notes,
                'category' => $request->category,
                'generated_at' => now()
            ]);

            // Régénérer le PDF
            $this->generatePdf($attestationRequest);

            return redirect()->route('admin.hr-attestations.show', $attestationRequest)
                ->with('success', 'Attestation mise à jour avec succès!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttestationRequest $attestationRequest)
    {
        try {
            // Supprimer le PDF si il existe
            if ($attestationRequest->pdf_path && Storage::exists($attestationRequest->pdf_path)) {
                Storage::delete($attestationRequest->pdf_path);
            }
            $attestationRequest->delete();

            return redirect()->route('admin.hr-attestations.index')
                ->with('success', 'Attestation supprimée avec succès!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le PDF de l'attestation
     */
    public function downloadPdf(AttestationRequest $attestationRequest)
    {
        if (!$attestationRequest->pdf_path || !Storage::exists($attestationRequest->pdf_path)) {
            return redirect()->back()
                ->with('error', 'Le fichier PDF n\'existe pas.');
        }

        $fileName = 'attestation_' . $attestationRequest->document_number . '.pdf';
        return Storage::download($attestationRequest->pdf_path, $fileName);
    }

    /**
     * Recherche d'utilisateurs pour l'autocomplétion
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');
        
        $users = User::where('role', '!=', 'admin')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->select('id', 'first_name', 'last_name', 'email', 'position')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')',
                    'position' => $user->position
                ];
            });

        return response()->json($users);
    }

    /**
     * Obtenir les détails d'un utilisateur
     */
    public function getUserDetails(User $user)
    {
        $user->load('department');
        
        return response()->json([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'position' => $user->position,
            'department' => $user->department ? $user->department->name : null,
            'salary' => $user->salary,
            'entry_date' => $user->entry_date ? $user->entry_date->format('Y-m-d') : null
        ]);
    }



    /**
     * Générer le PDF de l'attestation
     */
    private function generatePdf(AttestationRequest $attestation)
    {
        $attestation->load(['user', 'attestationType', 'generator']);
        
        $templateFile = $attestation->attestationType->template_file;
        $data = $this->prepareTemplateData($attestation);
        
        $pdf = Pdf::loadView("templates.attestations.{$templateFile}", $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        $fileName = 'hr_attestations/' . $attestation->document_number . '_' . Str::random(8) . '.pdf';
        
        $pdfOutput = $pdf->output();
        Storage::put($fileName, $pdfOutput);

        $attestation->update(['pdf_path' => $fileName]);
    }

    /**
     * Préparer les données pour le template
     */
    private function prepareTemplateData(AttestationRequest $attestation)
    {
        $employee = $attestation->user;
        $data = $attestation->custom_data ?? [];
        
        // Récupérer les données de l'entreprise depuis la base de données
        $company = \App\Models\Company::first();
        
        // Données de base
        $templateData = [
            // Données de l'entreprise
            'entreprise' => $company ? $company->name : 'Nom de l\'entreprise',
            'adresse_entreprise' => $company ? $company->address : 'Adresse de l\'entreprise',
            'code_postal_entreprise' => $company ? $company->postal_code : '',
            'ville_entreprise' => $company ? $company->city : 'Ville',
            'telephone_entreprise' => $company ? $company->contact_phone : 'Téléphone',
            'email_entreprise' => $company ? $company->contact_email : 'Email',
            'siret' => $company ? $company->registration_number : 'SIRET',
            'lieu' => $company ? $company->city : 'Ville',
            'logo_entreprise' => $company ? $company->logo : null,
            'globalCompanyCurrency' => $company ? $company->currency : '€',
            
            // Données du document
            'date_actuelle' => now()->format('d/m/Y'),
            'date_generation' => now()->format('d/m/Y H:i'),
            'numero_attestation' => $attestation->document_number,
            'numero_certificat' => $attestation->document_number,
            'numero_solde' => $attestation->document_number,
            
            // Données RH - Variables utilisées dans le template
            'hr_director_name' => $company && $company->hr_director_name ? $company->hr_director_name : ($attestation->generator ? ($attestation->generator->first_name . ' ' . $attestation->generator->last_name) : 'Directeur RH'),
            'hr_director_title' => 'Directeur des Ressources Humaines',
            'directeur_rh' => $company && $company->hr_director_name ? $company->hr_director_name : ($attestation->generator ? ($attestation->generator->first_name . ' ' . $attestation->generator->last_name) : 'Directeur RH'),
            'generateur' => $attestation->generator ? ($attestation->generator->first_name . ' ' . $attestation->generator->last_name) : 'Système',
            'hr_signature' => $company ? $company->hr_signature : null,
            'signature_drh' => $company ? $company->hr_signature : null,
            
            // Données de l'employé - Variables exactes du template
            'civilite' => $employee->gender === 'male' ? 'Monsieur' : 'Madame',
            'nom' => $employee->first_name . ' ' . $employee->last_name, // Template utilise $nom pour nom complet
            'prenom' => $employee->first_name,
            'nom_complet' => $employee->first_name . ' ' . $employee->last_name,
            'email' => $employee->email,
            'poste' => $employee->position,
            'departement' => $employee->department ? $employee->department->name : 'Département',
            'date_embauche' => $employee->entry_date ? $employee->entry_date->format('d/m/Y') : '',
            'type_contrat' => $employee->contract_type ?? 'CDI',
            'salaire' => $employee->salary,
            'adresse_employe' => $employee->address,
            'telephone_employe' => $employee->phone,
            'date_naissance' => $employee->birth_date ? $employee->birth_date->format('d/m/Y') : '',
            'lieu_naissance' => $employee->birth_place,
            'nationalite' => $employee->nationality,
            'numero_ss' => $employee->social_security_number ?? '',
            
            // Variables exactes utilisées dans le template certificat_travail
            'date_fin_contrat' => $attestation->end_date ? $attestation->end_date->format('d/m/Y') : ($data['date_fin_contrat'] ?? ''),
            'duree_contrat' => $data['duree_contrat'] ?? $this->calculateContractDuration($employee->entry_date, $attestation->end_date ?? $data['date_fin_contrat'] ?? null),
            'motif_fin' => $data['motif_fin_contrat'] ?? $data['motif_fin'] ?? '', // Mapper motif_fin_contrat vers motif_fin
            'salaire_final' => $data['salaire_final'] ?? $employee->salary ?? '',
            'appreciation' => $data['appreciation'] ?? 'L\'employé(e) a fait preuve de professionnalisme et de compétence durant toute la durée de son contrat.',
            'observations' => $data['observations'] ?? 'Aucune observation particulière.',
            
            // Variables spécifiques aux stages
            'date_debut_stage' => $attestation->start_date ? $attestation->start_date->format('d/m/Y') : ($data['date_debut_stage'] ?? ''),
            'date_fin_stage' => $attestation->end_date ? $attestation->end_date->format('d/m/Y') : ($data['date_fin_stage'] ?? ''),
            'date_debut' => $attestation->start_date ? $attestation->start_date->format('d/m/Y') : ($data['date_debut'] ?? ''),
            'date_fin' => $attestation->end_date ? $attestation->end_date->format('d/m/Y') : ($data['date_fin'] ?? ''),
            'duree_stage' => $data['duree_stage'] ?? $this->calculateContractDuration($attestation->start_date, $attestation->end_date),
            'maitre_stage' => $data['maitre_stage'] ?? ($company && $company->hr_director_name ? $company->hr_director_name : 'Maître de stage'),
            'missions_stage' => $data['missions_stage'] ?? 'Missions variées selon les besoins du service',
            'formation' => $data['formation'] ?? 'Formation',
            'etablissement' => $data['etablissement'] ?? 'Établissement',
            'niveau_etudes' => $data['niveau_etudes'] ?? 'Niveau d\'études',
            'competences_acquises' => $data['competences_acquises'] ?? '',
            
            // Variables pour attestation de présence
            'date_debut_periode' => isset($data['date_debut_periode']) ? 
                (is_string($data['date_debut_periode']) ? 
                    \Carbon\Carbon::parse($data['date_debut_periode'])->format('d/m/Y') : 
                    $data['date_debut_periode']) : 
                ($attestation->start_date ? $attestation->start_date->format('d/m/Y') : ''),
            'date_fin_periode' => isset($data['date_fin_periode']) ? 
                (is_string($data['date_fin_periode']) ? 
                    \Carbon\Carbon::parse($data['date_fin_periode'])->format('d/m/Y') : 
                    $data['date_fin_periode']) : 
                ($attestation->end_date ? $attestation->end_date->format('d/m/Y') : ''),
            'motif_fin_contrat' => $data['motif_fin_contrat'] ?? $data['motif_fin'] ?? '',
            
            // Données financières par défaut
            'solde_net' => '0,00',
            'total_brut' => '0,00',
            'total_deductions' => '0,00',
            'mode_paiement' => 'Virement bancaire',
            'date_paiement' => now()->format('d/m/Y')
        ];
        
        // Fusionner avec les données du formulaire
        return array_merge($templateData, $data);
    }

    /**
     * Calculer la durée du contrat
     */
    private function calculateContractDuration($hireDate, $endDate)
    {
        if (!$hireDate || !$endDate) {
            return '';
        }

        $start = \Carbon\Carbon::parse($hireDate);
        $end = \Carbon\Carbon::parse($endDate);
        
        $diff = $start->diff($end);
        
        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;
        
        $duration = [];
        
        if ($years > 0) {
            $duration[] = $years . ' an' . ($years > 1 ? 's' : '');
        }
        
        if ($months > 0) {
            $duration[] = $months . ' mois';
        }
        
        if ($days > 0 && $years == 0) {
            $duration[] = $days . ' jour' . ($days > 1 ? 's' : '');
        }
        
        return implode(', ', $duration);
    }
}
