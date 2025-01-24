<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mes demandes de congés') }}
            </h2>
            <a href="{{ route('leaves.create') }}" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nouvelle demande
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Solde de congés</h3>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <div class="text-sm text-blue-600">Congés annuels</div>
                                <div class="text-2xl font-bold">{{ auth()->user()->annual_leave_days }} jours</div>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <div class="text-sm text-green-600">Congés maladie</div>
                                <div class="text-2xl font-bold">{{ auth()->user()->sick_leave_days }} jours</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Mes demandes</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Date de début</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Date de fin</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Durée</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Pièces jointes</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Demandeur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider">Actions</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-100 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($leaves as $leave)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                    $leave->type === 'annual' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 
                                                    ($leave->type === 'sick' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                                    ($leave->type === 'unpaid' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                                                    'bg-gray-100 dark:bg-gray-900 text-gray-800')) 
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
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $leave->start_date->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $leave->end_date->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $leave->duration }} jours</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @switch($leave->status)
                                                    @case('pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:text-yellow-200 dark:bg-yellow-900">
                                                            En attente
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            Approuvé
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:text-red-200 dark:bg-red-900">
                                                            Refusé
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($leave->attachments->count() > 0)
                                                    <div class="flex flex-col space-y-1">
                                                        @foreach($leave->attachments as $attachment)
                                                            <a href="{{ route('leaves.attachment.download', $attachment) }}" 
                                                               class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                {{ $attachment->original_filename }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">Aucune pièce jointe</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $leave->user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $leave->user->department ? $leave->user->department->name : 'Non assigné' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($leave->status === 'pending' && (auth()->user()->id === $leave->user_id || auth()->user()->isAdmin()))
                                                    <a href="{{ route('leaves.edit', $leave->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </a>
                                                    <button 
                                                        x-data
                                                        x-on:click="$dispatch('show-cancel-modal', { url: '{{ route('leaves.destroy', $leave->id) }}' })"
                                                        class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i> Annuler
                                                    </button>
                                                @endif
                                                <a href="{{ route('leaves.show', $leave->id) }}" class="text-blue-600 hover:text-blue-900 ml-2">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($leave->status === 'pending')
                                                    {{-- <button type="button" 
                                                        title="Annuler"
                                                        x-data=""
                                                        x-on:click="$dispatch('show-cancel-modal', { url: '{{ route('leaves.destroy', $leave) }}' })"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-600">
                                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button> --}}
                                                @endif


                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-400">
                                                Aucune demande de congé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    


</x-app-layout>

 @push('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
@endpush

{{-- Modales --}}
<div x-data="{ 
    showCancelModal: false, 
    cancelUrl: ''
}"

    x-on:show-cancel-modal.window="showCancelModal = true; cancelUrl = $event.detail.url">
    
    {{-- Modale d'annulation --}}
    <div x-show="showCancelModal"
        x-transition
        class="fixed z-10 inset-0 overflow-y-auto"
        x-on:keydown.escape.window="showCancelModal = false">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                x-show="showCancelModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="showCancelModal = false">
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                x-show="showCancelModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
               
                <form x-bind:action="cancelUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Confirmer l'annulation
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Êtes-vous sûr de vouloir annuler cette demande de congé ? Cette action ne peut pas être annulée.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirmer l'annulation
                        </button>
                        <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            x-on:click="showCancelModal = false">
                            Retour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
