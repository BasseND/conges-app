<x-app-layout>
  

    <div class="pb-12">

        


        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
           <!-- Header -->
           

        <!-- En-tête moderne avec dégradé -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-xl shadow-lg mr-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ __('Notes de frais') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez vos demandes de remboursement de frais</p>
                        </div>
                    </div>
                    <a href="{{ route('expense-reports.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nouvelle note de frais</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="bg-white dark:bg-darkblack-600 rounded-lg p-4 mb-8">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
            
            <!-- Filtres et recherche modernisés -->
            <div class="mb-8">
                <form action="{{ route('expense-reports.index') }}" method="GET" class="space-y-6">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                        
                        <!-- Filtres modernisés -->
                        <div class="flex flex-wrap gap-4">
                            <!-- Filtre par statut -->
                            <div class="relative">
                                <select name="status" 
                                        id="status" 
                                        class="appearance-none bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200 min-w-[160px]">
                                    <option value="">Tous les statuts</option>
                                    @foreach(\App\Models\ExpenseReport::getStatusLabelAttribute() as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Filtre par date début -->
                            <div class="relative">
                                <input type="date" 
                                       name="date_from" 
                                       id="date_from" 
                                       value="{{ request('date_from') }}"
                                       placeholder="Date début"
                                       class="bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200 min-w-[160px]"/>
                            </div>

                            <!-- Filtre par date fin -->
                            <div class="relative">
                                <input type="date" 
                                       name="date_to" 
                                       id="date_to" 
                                       value="{{ request('date_to') }}"
                                       placeholder="Date fin"
                                       class="bg-white/50 dark:bg-gray-700/50 border border-gray-200/50 dark:border-gray-600/50 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-200 min-w-[160px]"/>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex items-center space-x-3">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Filtrer
                                </button>
                                @if(request()->hasAny(['status', 'date_from', 'date_to']))
                                    <a href="{{ route('expense-reports.index') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gray-500/80 hover:bg-gray-600/80 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Réinitialiser
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tableau des rapports de frais modernisé -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- En-tête du tableau -->
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200/50 dark:border-gray-600/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-500/10 dark:bg-green-400/10 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Liste des notes de frais</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-700/50">
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Référence</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Soumis par</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date de soumission</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Montant total</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Statut</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                            @forelse ($expenseReports as $report)
                                <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white">#{{ $report->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                                    {{ strtoupper(substr($report->user->first_name, 0, 1) . substr($report->user->last_name ?? '', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $report->user->first_name }} {{ $report->user->last_name ?? '' }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $report->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            <span class="text-sm text-gray-900 dark:text-white font-medium">
                                                {{ $report->submitted_at ? $report->submitted_at->format('d/m/Y') : 'Non soumis' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ number_format($report->total_amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-expense-status :status="$report->status" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <!-- Bouton Voir -->
                                            <a href="{{ route('expense-reports.show', $report) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-all duration-200 group" 
                                               title="Voir les détails">
                                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            
                                            <!-- Bouton Modifier (seulement si brouillon et auteur) -->
                                            @if($report->status === 'draft' && $report->user_id === auth()->id())
                                                <a href="{{ route('expense-reports.edit', $report) }}" 
                                                   class="inline-flex items-center justify-center w-8 h-8 text-amber-600 bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-all duration-200 group" 
                                                   title="Modifier">
                                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                            
                                            <!-- Bouton Supprimer (seulement si brouillon et auteur) -->
                                            @if($report->status === 'draft' && $report->user_id === auth()->id())
                                                <button @click="$dispatch('delete-dialog', '{{ route('expense-reports.destroy', $report) }}')" 
                                                        type="button" 
                                                        class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg transition-all duration-200 group" 
                                                        title="Supprimer">
                                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16">
                                        <div class="flex flex-col items-center justify-center space-y-6">
                                            <div class="relative">
                                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-2xl flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="text-center space-y-2">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Aucune note de frais trouvée
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm">
                                                    Commencez par créer votre première note de frais pour suivre vos dépenses professionnelles.
                                                </p>
                                            </div>
                                            <a href="{{ route('expense-reports.create') }}" 
                                               class="inline-flex items-center space-x-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span>Nouvelle note de frais</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination modernisée -->
                @if($expenseReports->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>
                                    Affichage de {{ $expenseReports->firstItem() }} à {{ $expenseReports->lastItem() }} 
                                    sur {{ $expenseReports->total() }} résultats
                                </span>
                            </div>
                            <div class="flex justify-center sm:justify-end">
                                {{ $expenseReports->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-modals.delete-dialog message="Etes-vous sur de vouloir supprimer cette note de frais ?" />

</x-app-layout>