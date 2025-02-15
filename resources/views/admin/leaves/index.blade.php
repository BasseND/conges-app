<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion des demandes de congés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Formulaire de recherche et filtres -->
                    <form action="{{ route('admin.leaves.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Recherche par nom -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Rechercher un employé</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Nom, email ou ID">
                        </div>

                        <!-- Département -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Département</label>
                            <select name="department" id="department"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Tous les départements</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Statut</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Tous les statuts</option>
                                @foreach(\App\Models\Leave::STATUSES as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type de congé -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Type de congé</label>
                            <select name="type" id="type"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Tous les types</option>
                                @foreach(\App\Models\Leave::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Période -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Période</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300  dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="md:col-span-4 flex justify-end space-x-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Filtrer
                            </button>

                            <a href="{{ route('admin.leaves.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Réinitialiser
                            </a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Employé</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Département</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Période</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Durée</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Motif</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Pièces jointes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-200 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($leaves as $leave)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $leave->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-200">{{ $leave->user->email }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-200">ID: {{ $leave->user->employee_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">{{ $leave->user->department?->name ?? 'Non assigné' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-200">{{ $leave->user->department?->code ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                $leave->type === 'annual' ? 'bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-200' : 
                                                ($leave->type === 'sick' ? 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-200' : 
                                                ($leave->type === 'unpaid' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-200' : 
                                                'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200')) 
                                            }}">
                                                @switch($leave->type)
                                                    @case('annual')
                                                        Congé annuel
                                                        @break
                                                    @case('sick')
                                                        Congé maladie
                                                        @break
                                                    @case('unpaid')
                                                        Congé sans solde
                                                        @break
                                                    @default
                                                        Autre
                                                @endswitch
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">Du {{ $leave->start_date->format('d/m/Y') }}</div>
                                            <div class="text-sm text-gray-900 dark:text-gray-200">Au {{ $leave->end_date->format('d/m/Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">
                                            {{ $leave->duration }} jour(s)
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-200">
                                            {{ Str::limit($leave->reason, 50) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($leave->attachments->count() > 0)
                                                <div class="flex flex-col space-y-1">
                                                    @foreach($leave->attachments as $attachment)
                                                        <a href="{{ route('leaves.attachment.download', $attachment) }}" 
                                                           class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            {{ $attachment->original_filename }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-200 text-sm">Aucune pièce jointe</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                $leave->status === 'approved' ? 'bg-green-100 text-green-800 dark:text-green-800' : 
                                                   ($leave->status === 'rejected' ? 'bg-red-100 text-red-800 dark:text-red-800' : 
                                                   'bg-yellow-100 text-yellow-800 dark:text-yellow-800') }}">
                                                @switch($leave->status)
                                                    @case('approved')
                                                        Approuvé
                                                        @break
                                                    @case('rejected')
                                                        Rejeté
                                                        @break
                                                    @default
                                                        En attente
                                                @endswitch
                                            </span>
                                            @if($leave->processed_at)
                                                <div class="text-xs text-gray-500 dark:text-gray-200 mt-1">
                                                    {{ $leave->processed_at->format('d/m/Y H:i') }}
                                                </div>
                                            @endif
                                        </td>
                                    

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($leave->status === 'pending' && auth()->user()->canManageUserLeaves($leave->user))
                                                <button title="Approuver" onclick="showApproveModal('{{ route('manager.leaves.approve', $leave) }}')" class="inline-flex items-center px-3 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                                   <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <button title="Rejeter" onclick="showRejectModal('{{ route('manager.leaves.reject', $leave) }}')" class="inline-flex items-center px-3 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @else
                                                @if($leave->status === 'approved')
                                                    <span class="text-green-600 dark:text-green-800">Approuvé</span>
                                                @elseif($leave->status === 'rejected')
                                                    <span class="text-red-600 dark:text-red-800">Rejeté</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Aucune demande de congé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">
                            {{ $leaves->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modals.approve-leave :action="''" />
    <x-modals.reject-leave :action="''" />

    @push('scripts')
    <script>
        function showApproveModal(action) {
            const modal = document.getElementById('approveModal');
            const form = document.getElementById('approveForm');
            form.action = action;
            modal.classList.remove('hidden');
        }

        function hideApproveModal() {
            const modal = document.getElementById('approveModal');
            modal.classList.add('hidden');
        }

        function showRejectModal(action) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = action;
            modal.classList.remove('hidden');
        }

        function hideRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            // Réinitialiser le formulaire
            document.getElementById('rejection_reason').value = '';
        }

        // Fermer les modales avec la touche Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideApproveModal();
                hideRejectModal();
            }
        });

        // Fermer les modales en cliquant en dehors
        window.onclick = function(event) {
            const approveModal = document.getElementById('approveModal');
            const rejectModal = document.getElementById('rejectModal');
            if (event.target === approveModal) {
                hideApproveModal();
            }
            if (event.target === rejectModal) {
                hideRejectModal();
            }
        }
    </script>
    @endpush 
</x-app-layout>


