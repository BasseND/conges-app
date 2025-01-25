Voici mon store : 
 public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
           // Validation de base
            try {

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
               
             } catch (\Illuminate\Validation\ValidationException $e) {
                dd([
                    'errors' => $e->errors(),
                    'has_errors' => session()->has('errors'),
                    'old_input' => old(),
                ]);
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }

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


    Voici ma vue blade : 
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle demande de congé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('leaves.store') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                         <input type="hidden" name="debug" value="1">

                        <div>
                            <x-input-label for="type" :value="__('Type de congé')" />
                            <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un type de congé</option>
                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Congé annuel</option>
                                <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Congé maladie</option>
                                <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>Congé sans solde</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">
                                Solde disponible : 
                                <span class="font-medium" id="annual_balance">{{ auth()->user()->annual_leave_days }} jours</span> de congés annuels, 
                                <span class="font-medium" id="sick_balance">{{ auth()->user()->sick_leave_days }} jours</span> de congés maladie
                            </p>
                        </div>

                        <div class="space-y-2 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Veuillez fournir un motif détaillé pour votre demande de congé.</p>
                        </div>

                        {{-- <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">Veuillez fournir un motif détaillé pour votre demande de congé.</p>
                        </div> --}}

                        <div>
                            <x-input-label for="attachments" :value="__('Pièces justificatives')" />
                            <input type="file" id="attachments" name="attachments[]" multiple 
                                class="block w-full text-sm text-gray-500 mt-1
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <p class="mt-2 text-sm text-gray-500">
                                Vous pouvez sélectionner plusieurs fichiers. Formats acceptés : PDF, JPG, PNG. Taille maximale : 10 MB par fichier.
                            </p>
                            <x-input-error :messages="$errors->get('attachments')" class="mt-2" />
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('leaves.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Soumettre la demande') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Définir seulement la date maximale (1 an dans le futur)
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);
            
            startDateInput.max = maxDate.toISOString().split('T')[0];
            endDateInput.max = maxDate.toISOString().split('T')[0];

            // Fonction pour vérifier si une date est un weekend
            function isWeekend(date) {
                const d = new Date(date);
                return d.getDay() === 0 || d.getDay() === 6;
            }

            // Fonction pour obtenir le prochain jour ouvrable
            function getNextWorkday(date) {
                const d = new Date(date);
                while (isWeekend(d)) {
                    d.setDate(d.getDate() + 1);
                }
                return d.toISOString().split('T')[0];
            }

            // Fonction pour obtenir le jour ouvrable précédent
            function getPreviousWorkday(date) {
                const d = new Date(date);
                while (isWeekend(d)) {
                    d.setDate(d.getDate() - 1);
                }
                return d.toISOString().split('T')[0];
            }

            // Gérer la sélection de dates
            startDateInput.addEventListener('change', function() {
                if (isWeekend(this.value)) {
                    this.value = getNextWorkday(this.value);
                }
                
                // Si la date de fin existe et est avant la date de début, l'ajuster
                if (endDateInput.value && new Date(endDateInput.value) < new Date(this.value)) {
                    endDateInput.value = this.value;
                }
            });

            endDateInput.addEventListener('change', function() {
                if (isWeekend(this.value)) {
                    this.value = getPreviousWorkday(this.value);
                }
                
                // Si la date de fin est avant la date de début, l'ajuster
                if (this.value && new Date(this.value) < new Date(startDateInput.value)) {
                    this.value = startDateInput.value;
                }
            });

            form.addEventListener('submit', function(e) {
                if (!startDateInput.value || !endDateInput.value) {
                    return;
                }

                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (isWeekend(startDate) || isWeekend(endDate)) {
                    e.preventDefault();
                    alert('Les dates de début et de fin ne peuvent pas être des weekends');
                    return;
                }

                if (endDate < startDate) {
                    e.preventDefault();
                    alert('La date de fin doit être après la date de début');
                    return;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>


Quand je soumets le formulaire, je ne vois pas de messages d'erreur, je reste dans le formulaire. Et les messages d'erreurs ne sont pas affichés.