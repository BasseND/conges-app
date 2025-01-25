Voici la methode show : 
public function show(Leave $leave)
    {
        if (!$leave || !$leave->exists) {
            \Log::error('Leave not found');
            abort(404, 'Demande de congé non trouvée');
        }

        \Log::info('Showing leave:', [
            'leave_id' => $leave->id,
            'user_id' => $leave->user_id,
            'auth_user_id' => auth()->id()
        ]);

        try {
            $this->authorize('view', $leave);
            
            // Eager load all necessary relationships
            $leave = Leave::with(['user.department', 'attachments', 'approver'])
                         ->findOrFail($leave->id);
            
            \Log::info('Leave loaded:', [
                'leave' => $leave->toArray(),
                'user' => $leave->user ? $leave->user->toArray() : null,
                'department' => $leave->user && $leave->user->department ? $leave->user->department->toArray() : null
            ]);

            return view('leaves.show', compact('leave'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Leave not found:', ['id' => $leave->id]);
            abort(404, 'Demande de congé non trouvée');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            \Log::error('Unauthorized access:', [
                'user_id' => auth()->id(),
                'leave_id' => $leave->id
            ]);
            abort(403, 'Vous n\'êtes pas autorisé à voir cette demande de congé');
        } catch (\Exception $e) {
            \Log::error('Error showing leave:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Une erreur est survenue lors de l\'affichage de la demande');
        }
    }

    Ma vue : 

    <x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Demande de congé') }}
            @if($leave->user_id)
                @php
                    \Log::info('User ID: ' . $leave->user_id);
                    \Log::info('User relation: ', ['user' => $leave->user]);
                @endphp
                @if($leave->user)
                    de {{ $leave->user->name }}
                @else
                    (Utilisateur ID: {{ $leave->user_id }})
                @endif
            @else
                (Aucun utilisateur associé)
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                 <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Demande de {{ $leave->user ? $leave->user->name : 'Utilisateur inconnu (ID: ' . $leave->user_id . ')' }}
                </h3>
                @php
                    \Log::info('Leave data:', [
                        'id' => $leave->id,
                        'created_at' => $leave->created_at,
                        'start_date' => $leave->start_date,
                        'end_date' => $leave->end_date
                    ]);
                @endphp
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    @if($leave->created_at)
                        Soumise le {{ $leave->created_at->format('d/m/Y à H:i') }}
                    @else
                        Date de soumission non disponible
                    @endif
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    {{-- <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Type de congé</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($leave->type === 'annual') bg-green-100 text-green-800
                                @elseif($leave->type === 'sick') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($leave->type) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Période</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}
                            ({{ $leave->duration_days }} jour(s))
                        </dd>
                    </div> --}}

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Type de congé</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($leave->type === 'annual') bg-green-100 text-green-800
                                @elseif($leave->type === 'sick') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($leave->type ?? 'inconnu') }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Période</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($leave->start_date && $leave->end_date)
                                Du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}
                                ({{ $leave->duration_days }} jour(s))
                            @else
                                Période non disponible
                            @endif
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Demandeur</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leave->user ? $leave->user->name : 'Utilisateur inconnu' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Département</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leave->user && $leave->user->department ? $leave->user->department->name : 'Non assigné' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Statut</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($leave->status === 'approved') bg-green-100 text-green-800
                                @elseif($leave->status === 'rejected') bg-red-100 text-red-800
                                @elseif($leave->status === 'cancelled') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Motif</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leave->reason }}
                        </dd>
                    </div>
                    @if($leave->status === 'rejected' && $leave->rejection_reason)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Motif du refus</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $leave->rejection_reason }}
                            </dd>
                        </div>
                    @endif
                    @if($leave->approved_by)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Traité par</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $leave->approver->name }} le {{ $leave->approved_at->format('d/m/Y à H:i') }}
                            </dd>
                        </div>
                    @endif
                    @if($leave->attachments->count() > 0)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Pièces jointes</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="mt-2 space-y-2">
                                    @foreach($leave->attachments as $attachment)
                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-lg shadow">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $attachment->original_filename }}</p>
                                                    <p class="text-xs text-gray-500">{{ number_format($attachment->size / 1024, 2) }} KB</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('leaves.download-attachment', ['leave' => $leave->id, 'attachment' => $attachment->id]) }}" 
                                               class="px-3 py-1 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Télécharger
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
            
            {{-- @can('update', $leave)
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('leaves.edit', $leave) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Modifier
                    </a>
                </div>
            @endcan --}}

            @can('update', $leave)
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('leaves.edit', ['leave' => $leave->id]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Modifier
                    </a>
                </div>
            @endcan

            @if(auth()->user()->can('approve-leaves') && $leave->status === 'pending')
                <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <form action="{{ route('leaves.reject', $leave) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center space-x-3">
                                <input type="text" name="rejection_reason" 
                                    class="block w-64 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                    placeholder="Motif du refus" required>
                                <button type="submit" class="btn-secondary" onclick="return confirm('Êtes-vous sûr de vouloir refuser cette demande ?')">
                                    Refuser
                                </button>
                            </div>
                        </form>
                        <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette demande ?')">
                                Approuver
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>


Et ma route : 
Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');

Et le lien dans mon index : 
<a href="{{ route('leaves.show', ['leave' => $leave->id]) }}" 
    class="text-indigo-600 hover:text-indigo-900 mr-3">
    Voir
</a>

Et quand je clique sur le lien, j'ai cette page  :

404
Page introuvable
