<x-app-layout>
  

    <div class="pb-12">

        


        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
           <!-- Header -->
           

            <!-- En-tête avec dégradé -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-bold text-white sm:text-3xl">
                                {{ __('Notes de frais') }}
                            </h1>
                        </div>
                    </div>
                    <a href="{{ route('expense-reports.create') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span> Nouvelle note de frais</span>
                    </a>
                </div> 
                <!-- Fil d'Ariane -->
                <nav class="mt-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('welcome.index') }}" class="text-blue-100 hover:text-white transition-colors duration-200">
                                Accueil
                            </a>
                        </li>
                        <li class="text-blue-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li class="text-white font-medium">
                            Notes de frais
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="p-6">
                <!-- Filtres -->
                <div class="mb-6">

                    <x-alert type="success" :message="session('success')" />
                    <x-alert type="error" :message="session('error')" />


                    <form action="{{ route('expense-reports.index') }}" method="GET" class="w-full bg-white dark:bg-darkblack-600 p-6 rounded-2xl shadow border border-transparent grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                            <select name="status" id="status" class="mt-1 block w-full bg-gray-50 dark:bg-dark-card-two border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-700 dark:text-white focus:border-violet-500">
                                <option value="">Tous les statuts</option>
                                @foreach(\App\Models\ExpenseReport::getStatusLabelAttribute() as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date début</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                class="mt-1 block w-full bg-gray-50 dark:bg-dark-card-two border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-700 dark:text-white focus:border-violet-500">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date fin</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="mt-1 block w-full bg-gray-50 dark:bg-dark-card-two border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-700 dark:text-white focus:border-violet-500">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="inline-flex justify-center items-center btn btn-vert-extra">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filtrer
                            </button>
                            @if(request()->hasAny(['status', 'date_from', 'date_to']))
                                <a href="{{ route('expense-reports.index') }}" 
                                class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Réinitialiser
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Référence
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Soumis par
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date de soumission
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Montant total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($expenseReports as $report)
                                <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        #{{ $report->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                       <span class="font-semibold text-base text-bgray-900 dark:text-white">{{ $report->user->first_name }} </span> 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold text-base text-bgray-900 dark:text-white">{{ $report->submitted_at ? $report->submitted_at->format('d/m/Y') : 'Non soumis' }}</span> 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">   
                                        <span class="font-semibold text-base text-bgray-900 dark:text-white">{{ number_format($report->total_amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}</span> 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex {{ 
                                            $report->status === 'paid' ? 'badge badge-success' : 
                                            ($report->status === 'draft' ? 'badge badge-info-outline  dark:bg-blue-900  dark:text-blue-200' : 
                                            ($report->status === 'approved' ? 'badge badge-success-outline dark:bg-green-900 dark:text-green-200' : 
                                            ($report->status === 'submitted' ? 'badge badge-warning-outline dark:bg-yellow-900 dark:text-yellow-200' :
                                            ($report->status === 'rejected' ? 'badge badge-error-outline dark:bg-red-900 dark:text-red-200' : 
                                            'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200'))))
                                        }}">
                                            @switch($report->status)
                                                @case('approved')
                                                    Approuvée
                                                    @break
                                                @case('submitted')
                                                    Soumise
                                                    @break
                                                @case('paid')
                                                    Payée
                                                    @break
                                                @case('rejected')
                                                    Rejetée
                                                    @break
                                                @default
                                                    Brouillon
                                            @endswitch
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a  title="Voir le detail" href="{{ route('expense-reports.show', $report) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if($report->status === 'draft')
                                                <a  title="Modifier" href="{{ route('expense-reports.edit', $report) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($report->status === 'draft')
                                                <button @click="$dispatch('delete-dialog', '{{ route('expense-reports.destroy', $report) }}')" 
                                                        title="Supprimer" 
                                                        type="button" 
                                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Aucune note de frais trouvée
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $expenseReports->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modals.delete-dialog message="Etes-vous sur de vouloir supprimer cette note de frais ?" />

</x-app-layout>