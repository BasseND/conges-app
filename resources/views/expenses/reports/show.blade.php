@section('title', 'Détails de la note de frais')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />

                    <!-- En-tête de la note -->
                    <div class="group relative bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-2xl p-8 mb-8 border border-blue-200/50 dark:border-gray-700/50">
                        <!-- Decorative background elements -->
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-400/10 to-indigo-500/10 rounded-full -translate-y-20 translate-x-20 group-hover:scale-110 transition-transform duration-700"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-teal-400/10 to-pink-500/10 rounded-full translate-y-16 -translate-x-16 group-hover:scale-110 transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <!-- Header with icon -->
                            <div class="flex items-center mb-8">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 rounded-2xl shadow-lg mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Détails de la note de frais</h2>
                                    <p class="text-gray-600 dark:text-gray-400">Informations complètes et statut</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Informations générales -->
                                <div class="space-y-6">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-800/20 p-6 rounded-2xl border border-blue-200/50 dark:border-blue-700/50">
                                        <div class="flex items-center mb-4">
                                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">Informations générales</h3>
                                        </div>
                                        <dl class="space-y-4">
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                    </svg>
                                                    Description
                                                </dt>
                                                <dd class="text-base font-semibold text-gray-900 dark:text-gray-100 ml-6">{{ $report->description }}</dd>
                                            </div>
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Montant total
                                                </dt>
                                                <dd class="text-2xl font-bold text-green-600 dark:text-green-400 ml-6">{{ number_format($report->total_amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}</dd>
                                            </div>
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                    </svg>
                                                    Créé par
                                                </dt>
                                                <dd class="text-base font-semibold text-gray-900 dark:text-gray-100 ml-6">{{ $report->user->first_name }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Statut et dates -->
                                <div class="space-y-6">
                                    <div class="bg-gradient-to-br from-teal-50 to-teal-100/50 dark:from-teal-900/20 dark:to-teal-800/20 p-6 rounded-2xl border border-teal-200/50 dark:border-teal-700/50">
                                        <div class="flex items-center mb-4">
                                            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-3 rounded-xl shadow-lg mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-teal-900 dark:text-teal-100">Statut et dates</h3>
                                        </div>
                                        <dl class="space-y-4">
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-2 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                                    </svg>
                                                    Statut
                                                </dt>
                                                <dd class="ml-6">
                                                    <x-expense-status :status="$report->status" />
                                                </dd>
                                            </div>
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                    </svg>
                                                    Créé le
                                                </dt>
                                                <dd class="text-base font-semibold text-gray-900 dark:text-gray-100 ml-6">{{ $report->created_at->format('d/m/Y H:i') }}</dd>
                                            </div>
                                            @if($report->submitted_at)
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    Soumis le
                                                </dt>
                                                <dd class="text-base font-semibold text-gray-900 dark:text-gray-100 ml-6">{{ $report->submitted_at->format('d/m/Y H:i') }}</dd>
                                            </div>
                                            @endif
                                            @if($report->approved_at)
                                            <div class="group/item hover:bg-white/50 dark:hover:bg-gray-800/50 p-3 rounded-xl transition-all duration-200">
                                                <dt class="text-sm font-medium text-teal-700 dark:text-teal-300 mb-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Approuvé le
                                                </dt>
                                                <dd class="text-base font-semibold text-gray-900 dark:text-gray-100 ml-6">{{ $report->approved_at->format('d/m/Y H:i') }}</dd>
                                            </div>
                                            @endif
                                        </dl>
                                    </div>
                                </div>
                               
                                <!-- Lignes de frais -->
                                <div class="w-full col-span-2">
                                    <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10 border border-orange-200 dark:border-orange-800 rounded-xl p-6 space-y-6 shadow-sm transition-shadow duration-200">
                                        
                                        <div class="flex items-center mb-4">
                                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mr-3">
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-orange-900 dark:text-orange-100">Lignes de frais</h3>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Description
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Catégorie
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Date
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Montant
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                            Justificatif
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($report->lines as $line)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                {{ $line->description }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                @if($line->category)
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                                        {{ $line->category_label }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-500 dark:text-gray-400">Non définie</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                {{ $line->spent_on->format('d/m/Y') }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                {{ number_format($line->amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                @if($line->receipt_path)
                                                                    <a href="{{ Storage::url($line->receipt_path) }}" 
                                                                        target="_blank"
                                                                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                        </svg>
                                                                        Voir
                                                                    </a>
                                                                @else
                                                                    <span class="text-gray-500 dark:text-gray-400">Aucun justificatif</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-right">
                                                            Total
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ number_format($report->total_amount, 2, ',', ' ') }} {{ $globalCompanyCurrency }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Boutons d'action -->
                                    <div class="mt-6 flex justify-between space-x-4">
                                        <a href="{{ route('expense-reports.index') }}" 
                                            class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            Retour à la liste
                                        </a>
                                        <div class="flex justify-end gap-3">
                                            @if($report->status === 'draft' && $report->user_id === auth()->id())
                                                <a href="{{ route('expense-reports.edit', $report) }}" 
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Modifier
                                                </a>
                                            @endif
                                            @if($report->status === 'draft' && $report->user_id === auth()->id())
                                                <button @click="$dispatch('submit-expense', '{{ route('expense-reports.submit', $report) }}')" 
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 rounded-lg border border-green-600 dark:border-green-700 transition-colors shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                    </svg>
                                                    Soumettre
                                                </button>
                                            @endif

                                            @if(auth()->user()->canApproveExpenseReports())
                                                @if($report->status === 'submitted')
                                                    <button @click="$dispatch('approve-expense', '{{ route('expense-reports.approve', $report) }}')"
                                                        type="button"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800 transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Valider
                                                    </button>
                                                    <button @click="$dispatch('reject-expense', '{{ route('expense-reports.reject', $report) }}')"
                                                        type="button"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800 transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Rejeter
                                                    </button>
                                                @endif
                                                @if(auth()->user()->canPayExpenseReports() && auth()->user()->role === 'rh')
                                                    @if($report->status === 'approved')
                                                        <button @click="$dispatch('pay-expense', '{{ route('expense-reports.pay', $report) }}')"
                                                            type="button"
                                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Payer
                                                        </button>
                                                    @endif
                                                @endcan
                                            @endif
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    


                </div>
            </div>
        </div>
    </div>
    <x-modals.approve-expense message="Êtes-vous sûr de vouloir valider cette note de frais ? Une fois validée, elle ne pourra plus être modifiée." />
    <x-modals.submit-expense message="Êtes-vous sûr de vouloir soumettre cette note de frais ? Une fois soumise, elle ne pourra plus être modifiée." />
    <x-modals.reject-expense message="Êtes-vous sûr de vouloir rejeter cette note de frais ? Une fois rejetée, elle ne pourra plus être modifiée." />
    <x-modals.pay-expense message="Êtes-vous sûr de vouloir payer cette note de frais ? Une fois payée, elle ne pourra plus être modifiée." />
</x-app-layout>