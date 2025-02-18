<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Validation des congés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Formulaire de recherche et filtres -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 dark:bg-gray-800">
                <div class="p-6 bg-white border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('manager.leaves.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Recherche par nom -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Rechercher un employé</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                placeholder="Nom, email ou ID">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de congé</label>
                            <select name="type" id="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Tous les types</option>
                                @foreach(\App\Models\Leave::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Période -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Période</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="md:col-span-3 flex justify-end space-x-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Filtrer
                            </button>

                            <a href="{{ route('manager.leaves.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($leaves->isEmpty())
                        <p class="text-gray-500 text-center py-4">Aucune demande de congé trouvée.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Employé
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Département
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Période
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Durée
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $leave->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $leave->user->email }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ $leave->user->employee_id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $leave->user->department->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $leave->user->department->code }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                    $leave->type === 'annual' ? 'bg-blue-100 text-blue-800' : 
                                                    ($leave->type === 'sick' ? 'bg-green-100 text-green-800' : 
                                                    ($leave->type === 'unpaid' ? 'bg-yellow-100 text-yellow-800' : 
                                                    'bg-gray-100 text-gray-800')) 
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Du {{ $leave->start_date->format('d/m/Y') }}
                                                <br>
                                                Au {{ $leave->end_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $leave->duration }} jour(s)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($leave->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                                       'bg-yellow-100 text-yellow-800') }}">
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
                                                    <div class="text-xs text-gray-500 mt-1">
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
                                                        <span class="text-green-600">Approuvé</span>
                                                    @elseif($leave->status === 'rejected')
                                                        <span class="text-red-600">Rejeté</span>
                                                    @endif
                                                @endif

                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($leaves instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="mt-4 flex justify-center">
                                {{ $leaves->links() }}
                            </div>
                        @endif
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
