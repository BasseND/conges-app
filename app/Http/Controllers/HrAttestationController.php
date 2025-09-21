<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrAttestation;
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
        $query = HrAttestation::with(['employee', 'attestationType', 'generatedBy'])
            ->hrGenerated()
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('employee_search')) {
            $search = $request->employee_search;
            $query->whereHas('employee', function ($q) use ($search) {
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

        if ($request->filled('date_from')) {
            $query->whereDate('generated_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('generated_at', '<=', $request->date_to);
        }

        $attestations = $query->paginate(15);
        $attestationTypes = AttestationType::whereIn('type', ['salary', 'employment', 'presence'])->get();
        $statuses = HrAttestation::getStatuses();

        return view('admin.hr-attestations.index', compact('attestations', 'attestationTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attestationTypes = AttestationType::whereIn('type', ['salary', 'employment', 'presence'])->where('status', 'active')->get();
        return view('admin.hr-attestations.create', compact('attestationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,id',
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'data' => 'required|array',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $attestation = HrAttestation::create([
                'employee_id' => $request->employee_id,
                'attestation_type_id' => $request->attestation_type_id,
                'generated_by' => Auth::id(),
                'status' => HrAttestation::STATUS_GENERATED,
                'data' => $request->data,
                'notes' => $request->notes,
                'generated_at' => now()
            ]);

            // Générer le PDF
            $this->generatePdf($attestation);

            return redirect()->route('admin.hr-attestations.index')
                ->with('success', 'Attestation générée avec succès pour ' . $attestation->employee->first_name . ' ' . $attestation->employee->last_name . '!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la génération de l\'attestation: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HrAttestation $hrAttestation)
    {
        $hrAttestation->load(['employee.department', 'attestationType', 'generatedBy']);
        return view('admin.hr-attestations.show', compact('hrAttestation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrAttestation $hrAttestation)
    {
        $hrAttestation->load(['employee', 'attestationType']);
        $attestationTypes = AttestationType::whereIn('type', ['salary', 'employment', 'presence'])->where('status', 'active')->get();
        return view('admin.hr-attestations.edit', compact('hrAttestation', 'attestationTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrAttestation $hrAttestation)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,id',
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'data' => 'required|array',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Supprimer l'ancien PDF
            $hrAttestation->deleteOldPdf();

            // Mettre à jour l'attestation
            $hrAttestation->update([
                'employee_id' => $request->employee_id,
                'attestation_type_id' => $request->attestation_type_id,
                'data' => $request->data,
                'notes' => $request->notes,
                'generated_at' => now()
            ]);

            // Régénérer le PDF
            $this->generatePdf($hrAttestation);

            return redirect()->route('hr-attestations.show', $hrAttestation)
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
    public function destroy(HrAttestation $hrAttestation)
    {
        try {
            $hrAttestation->deleteOldPdf();
            $hrAttestation->delete();

            return redirect()->route('hr-attestations.index')
                ->with('success', 'Attestation supprimée avec succès!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le PDF de l'attestation
     */
    public function downloadPdf(HrAttestation $hrAttestation)
    {
        if (!$hrAttestation->hasPdf()) {
            return redirect()->back()
                ->with('error', 'Le fichier PDF n\'existe pas.');
        }

        $fileName = 'attestation_' . $hrAttestation->document_number . '.pdf';
        return Storage::download($hrAttestation->pdf_path, $fileName);
    }

    /**
     * Recherche d'employés pour l'autocomplétion
     */
    public function searchEmployees(Request $request)
    {
        $search = $request->get('q', '');
        
        $employees = User::where('role', '!=', 'admin')
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

        return response()->json($employees);
    }

    /**
     * Obtenir les détails d'un employé
     */
    public function getEmployeeDetails(User $employee)
    {
        return response()->json([
            'id' => $employee->id,
            'first_name' => $employee->first_name,
            'last_name' => $employee->last_name,
            'email' => $employee->email,
            'position' => $employee->position,
            'department' => $employee->department ? $employee->department->name : null,
            'hire_date' => $employee->hire_date,
            'contract_type' => $employee->contract_type,
            'salary' => $employee->salary,
            'address' => $employee->address,
            'phone' => $employee->phone,
            'birth_date' => $employee->birth_date,
            'birth_place' => $employee->birth_place,
            'nationality' => $employee->nationality
        ]);
    }

    /**
     * Générer le PDF de l'attestation
     */
    private function generatePdf(HrAttestation $attestation)
    {
        $attestation->load(['employee', 'attestationType', 'generatedBy']);
        
        $templateFile = $attestation->attestationType->template_file;
        $data = $this->prepareTemplateData($attestation);
        
        $pdf = Pdf::loadView("templates.attestations.{$templateFile}", $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
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
    private function prepareTemplateData(HrAttestation $attestation)
    {
        $employee = $attestation->employee;
        $data = $attestation->data;
        
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
            'hr_director_name' => $company && $company->hr_director_name ? $company->hr_director_name : ($attestation->generatedBy->first_name . ' ' . $attestation->generatedBy->last_name),
            'hr_director_title' => 'Directeur des Ressources Humaines',
            'directeur_rh' => $company && $company->hr_director_name ? $company->hr_director_name : ($attestation->generatedBy->first_name . ' ' . $attestation->generatedBy->last_name),
            'generateur' => $attestation->generatedBy->first_name . ' ' . $attestation->generatedBy->last_name,
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
            'date_fin_contrat' => $data['date_fin_contrat'] ?? '',
            'duree_contrat' => $data['duree_contrat'] ?? $this->calculateContractDuration($employee->entry_date, $data['date_fin_contrat'] ?? null),
            'motif_fin' => $data['motif_fin_contrat'] ?? $data['motif_fin'] ?? '', // Mapper motif_fin_contrat vers motif_fin
            'salaire_final' => $data['salaire_final'] ?? $employee->salary ?? '',
            'appreciation' => $data['appreciation'] ?? 'L\'employé(e) a fait preuve de professionnalisme et de compétence durant toute la durée de son contrat.',
            'observations' => $data['observations'] ?? 'Aucune observation particulière.',
            
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
