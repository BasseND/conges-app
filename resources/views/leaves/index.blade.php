<x-app-layout>
    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-bgray-900 dark:text-white">
                        {{ __('Mes demandes de congés') }}
                    </h2>
                    <a href="{{ route('leaves.create') }}" class="btn btn-primary inline-flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    Nouvelle demande
                    </a>
                </div>

            </div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="font-semibold text-base block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Solde de congés</h3>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4 mt-5">
                        <!-- Congés annuels -->
                        <div class="rounded-xl bg-bgray-200 p-7 dark:bg-darkblack-500">
                            <div class="flex flex-row items-center space-x-6 md:flex-col md:space-x-0 2xl:flex-row 2xl:space-x-6">
                            <div class="progess-bar mb-0 flex justify-center md:mb-[13px] xl:mb-0">
                                <div class="bonus-per relative">
                                <div class="bonus-outer">
                                    <div class="bonus-inner">
                                    <div class="number">
                                        <span class="text-sm font-medium text-bgray-900"
                                        >64%</span
                                        >
                                    </div>
                                    </div>
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="80px"
                                    height="80px"
                                >
                                    <circle
                                    style="
                                        stroke-dashoffset: calc(215 - 215 * (64 / 100));
                                    "
                                    cx="40"
                                    cy="40"
                                    r="35"
                                    stroke-linecap="round"
                                    />
                                </svg>
                                </div>
                            </div>
                            <div class="flex flex-col items-start md:items-center xl:items-start">
                                <h4 class="text-base font-bold text-bgray-900 dark:text-white">
                                   Congés annuels
                                </h4>
                                <span class="text-2xl font-bold dark:text-darkblack-300">
                                    {{ auth()->user()->annual_leave_days }} jours
                                </span>
                            </div>
                            </div>
                        </div>

                        <!-- Conges Maladies -->
                        <div class="rounded-xl bg-success-50 p-7 dark:bg-darkblack-500">
                            <div class="flex flex-row items-center space-x-6 md:flex-col md:space-x-0 2xl:flex-row 2xl:space-x-6">
                            <div  class="progess-bar mb-0 flex justify-center md:mb-[13px] xl:mb-0">
                                <div class="bonus-per relative">
                                <div class="bonus-outer">
                                    <div class="bonus-inner">
                                    <div class="number">
                                        <span class="text-sm font-medium text-bgray-900"
                                        >64%</span
                                        >
                                    </div>
                                    </div>
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="80px"
                                    height="80px"
                                >
                                    <circle
                                    style="
                                        stroke-dashoffset: calc(215 - 215 * (64 / 100));
                                    "
                                    cx="40"
                                    cy="40"
                                    r="35"
                                    stroke-linecap="round"
                                    />
                                </svg>
                                </div>
                            </div>
                            <div class="flex flex-col items-start md:items-center xl:items-start">
                                <h4 class="text-base font-bold text-bgray-900 dark:text-white">
                                   Congés maladie
                                </h4>
                                <span class="text-2xl font-bold dark:text-darkblack-300">
                                    {{ auth()->user()->sick_leave_days }} jours
                                </span>
                            </div>
                            </div>
                        </div>

                         <!-- Congé Maternité -->
                        <div class="rounded-xl bg-pink-50 p-7 dark:bg-darkblack-500">
                            <div class="flex flex-row items-center space-x-6 md:flex-col md:space-x-0 2xl:flex-row 2xl:space-x-6">
                            <div  class="progess-bar mb-0 flex justify-center md:mb-[13px] xl:mb-0">
                                <div class="bonus-per relative">
                                <div class="bonus-outer">
                                    <div class="bonus-inner">
                                    <div class="number">
                                        <span class="text-sm font-medium text-bgray-900"
                                        >100%</span
                                        >
                                    </div>
                                    </div>
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="80px"
                                    height="80px"
                                >
                                    <circle
                                    style="
                                        stroke-dashoffset: calc(215 - 215 * (100 / 100));
                                    "
                                    cx="40"
                                    cy="40"
                                    r="35"
                                    stroke-linecap="round"
                                    />
                                </svg>
                                </div>
                            </div>
                            <div class="flex flex-col items-start md:items-center xl:items-start">
                                <h4 class="text-base font-bold text-bgray-900 dark:text-white">
                                   Congé maternité
                                </h4>
                                <span class="text-2xl font-bold dark:text-darkblack-300">
                                    {{ auth()->user()->maternity_leave_days }} jours
                                </span>
                            </div>
                            </div>
                        </div>

                        <!-- Congé Paternité -->
                        <div class="rounded-xl bg-blue-50 p-7 dark:bg-darkblack-500">
                            <div class="flex flex-row items-center space-x-6 md:flex-col md:space-x-0 2xl:flex-row 2xl:space-x-6">
                            <div  class="progess-bar mb-0 flex justify-center md:mb-[13px] xl:mb-0">
                                <div class="bonus-per relative">
                                <div class="bonus-outer">
                                    <div class="bonus-inner">
                                    <div class="number">
                                        <span class="text-sm font-medium text-bgray-900"
                                        >100%</span
                                        >
                                    </div>
                                    </div>
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="80px"
                                    height="80px"
                                >
                                    <circle
                                    style="
                                        stroke-dashoffset: calc(215 - 215 * (100 / 100));
                                    "
                                    cx="40"
                                    cy="40"
                                    r="35"
                                    stroke-linecap="round"
                                    />
                                </svg>
                                </div>
                            </div>
                            <div class="flex flex-col items-start md:items-center xl:items-start">
                                <h4 class="text-base font-bold text-bgray-900 dark:text-white">
                                   Congé paternité
                                </h4>
                                <span class="text-2xl font-bold dark:text-darkblack-300">
                                    {{ auth()->user()->paternity_leave_days }} jours
                                </span>
                            </div>
                            </div>
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
                                            <x-leave-type-badge :type="$leave->type" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->start_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->end_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->duration }} jours</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($leave->status)
                                                @case('pending')
                                                    <span class="rounded-md bg-[#FDF9E9] px-4 py-1.5 text-sm font-semibold leading-[22px] text-warning-300 dark:bg-darkblack-500">
                                                        En attente
                                                    </span>
                                                    @break
                                                @case('approved')
                                                    <span class="rounded-md bg-success-50 px-4 py-1.5 text-sm font-semibold leading-[22px] text-success-400 dark:bg-darkblack-500">
                                                        Approuvé
                                                    </span>
                                                    @break
                                                @case('rejected')
                                                    <span class="rounded-md bg-[#FAEFEE] px-4 py-1.5 text-sm font-semibold leading-[22px] text-[#FF4747] dark:bg-darkblack-500">
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
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $leave->user->first_name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $leave->user->department ? $leave->user->department->name : 'Non assigné' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2 text-right text-sm font-medium">

                                            <a href="{{ route('leaves.show', ['leave' => $leave->id]) }}" 
                                                class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($leave->status === 'pending' && (auth()->user()->id === $leave->user_id || auth()->user()->hasAdminAccess()))
                                                <a href="{{ route('leaves.edit', ['leave' => $leave->id]) }}" class="text-indigo-600 dark:text-indigo-500 hover:text-indigo-900 dark:hover:text-indigo-700 mr-2">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <button
                                                    @click="$dispatch('delete-dialog', '{{ route('leaves.destroy', $leave->id) }}')"
                                                    title="Annuler"
                                                    type="button" 
                                                    class="text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-700">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                </button>
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
    {{-- Modales --}}
    <x-modals.delete-dialog message="Êtes-vous sûr de vouloir annuler cette demande de congé ? Cette action ne peut pas être annulée." />

</x-app-layout>