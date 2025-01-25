<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveAttachment;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    /**
     * Affiche la liste des congés de l'utilisateur connecté
     */
    public function index()
    {
        $leaves = Leave::with(['user.department', 'attachments'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('leaves.index', compact('leaves'));
    }

    /**
     * Affiche le formulaire de création d'une demande de congé
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Enregistre une nouvelle demande de congé
     */

     public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
           // Validation de base
            

                 $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'start_date' => [
                    'required',
                    'date',
                    'before:+1 year',
                    function ($attribute, $value, $fail) {
                        $startDate = Carbon::parse($value);
                        if ($startDate->isWeekend()) {
                            $fail('La date de début ne peut pas être un weekend.');
                        }
                    }
                ],
                'end_date' => [
                    'required',
                    'date',
                    'after_or_equal:start_date',
                    function ($attribute, $value, $fail) {
                        $endDate = Carbon::parse($value);
                        if ($endDate->isWeekend()) {
                            $fail('La date de fin ne peut pas être un weekend.');
                        }
                    }
                ],
                'type' => ['required', Rule::in(['annual', 'sick', 'unpaid', 'other'])],
                'reason' => ['required', 'string', 'min:10', 'max:500'],
                'attachments.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048']
            ], [
                'start_date.required' => 'La date de début est requise.',
                'start_date.date' => 'La date de début doit être une date valide.',
                'start_date.before' => 'La date de début doit être dans moins d\'un an.',
                'end_date.required' => 'La date de fin est requise.',
                'end_date.date' => 'La date de fin doit être une date valide.',
                'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
                'type.required' => 'Le type de congé est requis.',
                'type.in' => 'Le type de congé sélectionné n\'est pas valide.',
                'reason.required' => 'Le motif est requis.',
                'reason.min' => 'Le motif doit faire au moins :min caractères.',
                'reason.max' => 'Le motif ne peut pas dépasser :max caractères.',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }

            $validated = $validator->validated();
               
           

            // Vérification des chevauchements
            $start = Carbon::parse($validated['start_date']);
            $end = Carbon::parse($validated['end_date']);
            
            $existingLeave = Leave::query()
                ->where('user_id', auth()->id())
                ->where('status', '!=', 'rejected')
                ->where(function ($query) use ($start, $end) {
                    $query->where(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $start);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $end)
                          ->where('end_date', '>=', $end);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '>=', $start)
                          ->where('end_date', '<=', $end);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $end);
                    });
                })
                ->first();

            if ($existingLeave) {
                return back()->withInput()->with('error', sprintf(
                    'Cette période chevauche un congé existant du %s au %s.',
                    $existingLeave->start_date->format('d/m/Y'),
                    $existingLeave->end_date->format('d/m/Y')
                ));
            }

            // Calcul de la durée en jours ouvrables
            $duration = 0;
            for ($date = clone $start; $date->lte($end); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            // Vérification de la durée maximale
            $maxDuration = match($validated['type']) {
                'annual' => 30,
                'sick' => 90,
                'unpaid' => 60,
                'other' => 5,
                default => 30,
            };

            if ($duration > $maxDuration) {
                return back()->withInput()->with('error', 
                    "La durée maximale pour ce type de congé est de {$maxDuration} jours ouvrables."
                );
            }

            // Création du congé
            $leave = new Leave($validated);
            $leave->user_id = auth()->id();
            $leave->status = 'pending';
            $leave->duration = $duration;
            
            if (!$leave->save()) {
                throw new \Exception('Erreur lors de la sauvegarde du congé');
            }

            // Gestion des pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave_attachments');
                    $leave->attachments()->create([
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('leaves.index')
                ->with('success', 'Votre demande de congé a été soumise avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function storeNew(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type' => 'required|in:annual,sick,unpaid,other',
                'reason' => 'required|string|min:10|max:500'
            ]);

            // Calcul de la durée en jours (en excluant les weekends)
            $start = Carbon::parse($validated['start_date']);
            $end = Carbon::parse($validated['end_date']);
            $duration = 0;

            for ($date = clone $start; $date->lte($end); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            $leave = new Leave($validated);
            $leave->user_id = auth()->id();
            $leave->status = 'pending';
            $leave->duration = $duration;
            
            if (!$leave->save()) {
                throw new \Exception('Erreur lors de la sauvegarde du congé');
            }

            // Gérer les pièces jointes après avoir sauvegardé la demande
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave_attachments');
                    $leave->attachments()->create([
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('leaves.index')
                ->with('success', 'Votre demande de congé a été soumise avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

      public function storeENCOURS(LeaveRequest $request)
    {
        try {

             // Validation manuelle pour déboguer
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type' => 'required|in:annual,sick,unpaid,other',
                'reason' => 'required|string|min:10|max:500'
            ]);
            
            if ($validator->fails()) {
                dd('Validation errors:', $validator->errors()->all());
            }
            
            // DB::beginTransaction();
            
            // $validated = $request->validated();

            DB::beginTransaction();
            
            $validated = $request->validated();
            //  dd($validated); // Ajoutez cette ligne temporairement
            Log::info('Données validées:', $validated);

            // Calcul de la durée en jours (en excluant les weekends)
            $start = \Carbon\Carbon::parse($validated['start_date']);
            $end = \Carbon\Carbon::parse($validated['end_date']);
            $duration = 0;

            for ($date = $start; $date->lte($end); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            Log::info('Durée calculée:', ['duration' => $duration]);

            $leave = new Leave($validated);
            $leave->user_id = auth()->id();
            $leave->status = 'pending';
            $leave->duration = $duration;
            
            if (!$leave->save()) {
                Log::error('Erreur lors de la sauvegarde:', $leave->getAttributes());
                throw new \Exception('Erreur lors de la sauvegarde du congé');
            }

            Log::info('Congé enregistré avec succès:', ['id' => $leave->id]);

            // Gérer les pièces jointes après avoir sauvegardé la demande
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave_attachments');
                    $leave->attachments()->create([
                        'filename' => $path,
                        'original_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize()
                    ]);
                }
                Log::info('Pièces jointes enregistrées');
            }

            DB::commit();
            
            return redirect()->route('leaves.index')
                ->with('success', 'Votre demande de congé a été soumise avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'enregistrement:', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre demande.');
        }
    }

    public function storeOLD(LeaveRequest  $request)
    {
        // $validated = $request->validate([
        //     'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        //     'reason' => 'required|string|max:500',
        //     'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
        // ]);

        $validated = $request->validated();

        // Calcul de la durée en jours (en excluant les weekends)
        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end = \Carbon\Carbon::parse($validated['end_date']);
        $duration = 0;

        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        $leave = new Leave($validated);
        $leave->user_id = auth()->id();
        $leave->status = 'pending';
        $leave->duration = $duration;
        $leave->save();

        // Gérer les pièces jointes après avoir sauvegardé la demande
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('leave_attachments');
                $leave->attachments()->create([
                    'filename' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);
            }
        }

        return redirect()->route('leaves.index')
            ->with('success', 'Votre demande de congé a été soumise avec succès.');
    }

    /**
     * Affiche les détails d'une demande de congé
     */
    public function show(Leave $leave)
    {
        $this->authorize('view', $leave);
        $leave->load(['user.department', 'attachments', 'approver']);
        return view('leaves.show', compact('leave'));
    }

    /**
     * Télécharge la pièce jointe d'une demande de congé
     */
    public function downloadAttachment(Leave $leave, LeaveAttachment $attachment)
    {
        $this->authorize('view', $leave);

        if (!Storage::exists($attachment->filename)) {
            abort(404, 'Pièce jointe introuvable');
        }

        return Storage::download(
            $attachment->filename,
            $attachment->original_filename,
            ['Content-Type' => $attachment->mime_type]
        );
    }

    /**
     * Affiche la liste des demandes de congés pour le manager
     */
    public function managerIndex(Request $request)
    {
        $query = Leave::with(['user', 'user.department'])
            ->whereHas('user', function ($q) {
                $q->where('department_id', auth()->user()->department_id);
            });

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status') && array_key_exists($request->status, Leave::STATUSES)) {
            $query->where('status', $request->status);
        }

        // Filtre par type de congé
        if ($request->filled('type') && array_key_exists($request->type, Leave::TYPES)) {
            $query->where('type', $request->type);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->latest()->paginate(10);
        
        // Conserver les paramètres de filtrage dans les liens de pagination
        $leaves->appends($request->only(['search', 'status', 'type', 'date_from', 'date_to']));

        return view('manager.leaves.index', compact('leaves'));
    }

    /**
     * Approuve une demande de congé
     */
    public function approve(Leave $leave)
    {
        if (!auth()->user()->can('approve-leaves')) {
            abort(403, 'Vous n\'avez pas l\'autorisation d\'approuver les demandes de congé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('success', 'La demande de congé a été approuvée.');
    }

    /**
     * Rejette une demande de congé
     */
    public function reject(Request $request, Leave $leave)
    {
        if (!auth()->user()->can('approve-leaves')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de refuser les demandes de congé.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason']
        ]);

        return redirect()->back()->with('success', 'La demande de congé a été refusée.');
    }

    /**
     * Annule une demande de congé
     */
    public function destroy(Leave $leave)
    {
        $this->authorize('delete', $leave);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Vous ne pouvez annuler que les demandes en attente.');
        }

        try {
            $leave->update([
                'status' => 'cancelled',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            return redirect()->route('leaves.index')->with('success', 'La demande de congé a été annulée.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation de la demande.');
        }
    }

    /**
     * Affiche le formulaire d'édition d'une demande de congé
     */
    public function edit(Leave $leave)
    {
        $this->authorize('update', $leave);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Vous ne pouvez modifier que les demandes en attente.');
        }

        return view('leaves.edit', compact('leave'));
    }

    /**
     * Met à jour une demande de congé
     */
    public function update(Request $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Vous ne pouvez modifier que les demandes en attente.');
        }

        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', array_keys(Leave::TYPES)),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        // Calculer la durée en jours ouvrables
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $duration = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $duration++;
            }
        }

        DB::beginTransaction();
        try {
            $leave->update([
                'type' => $validated['type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'duration' => $duration,
                'reason' => $validated['reason']
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('leave-attachments', 'public');
                    $leave->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('leaves.show', $leave)->with('success', 'Demande de congé mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la demande.');
        }
    }
}
