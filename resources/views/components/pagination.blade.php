@props(['paginator', 'entityName' => 'éléments'])

@if($paginator->hasPages())
    <div class="mt-6 px-6 py-4  border-t border-gray-200 dark:border-gray-600">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <span class="mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </span>
                        <span class="mr-2">Affichage de</span>
                        <span class="font-semibold text-green-600 dark:text-green-400">{{ $paginator->firstItem() }}</span>
                         <span class="mx-1">à</span>
                         <span class="font-semibold text-green-600 dark:text-green-400">{{ $paginator->lastItem() }}</span>
                         <span class="mx-1">sur</span>
                         <span class="font-semibold text-green-600 dark:text-green-400">{{ $paginator->total() }}</span>
                        <span class="ml-1">{{ $entityName }}</span>
                    </div>
            
            <div class="flex items-center space-x-1 md:space-x-2">
                {{-- Bouton Précédent --}}
                 @if($paginator->onFirstPage())
                     <span class="inline-flex items-center px-2 md:px-3 py-2 text-xs md:text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-not-allowed">
                         <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                         </svg>
                         <span class="hidden md:inline">Précédent</span>
                     </span>
                 @else
                     <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-2 md:px-3 py-2 text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 hover:scale-105">
                         <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                         </svg>
                         <span class="hidden md:inline">Précédent</span>
                     </a>
                 @endif
                
                {{-- Numéros de pages (masqués sur mobile) --}}
                        <div class="hidden md:flex items-center space-x-1">
                            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                                @if($page == $paginator->currentPage())
                                    <span class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-600 border border-green-500 rounded-lg shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 hover:scale-105">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- Indicateur de page actuelle (visible sur mobile uniquement) --}}
                        <div class="md:hidden flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="font-semibold text-green-600 dark:text-green-400">{{ $paginator->currentPage() }}</span>
                             <span class="mx-1">/</span>
                             <span class="font-semibold text-green-600 dark:text-green-400">{{ $paginator->lastPage() }}</span>
                        </div>
                
                {{-- Bouton Suivant --}}
                 @if($paginator->hasMorePages())
                     <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-2 md:px-3 py-2 text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 hover:scale-105">
                         <span class="hidden md:inline">Suivant</span>
                         <svg class="w-4 h-4 md:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                         </svg>
                     </a>
                 @else
                     <span class="inline-flex items-center px-2 md:px-3 py-2 text-xs md:text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-not-allowed">
                         <span class="hidden md:inline">Suivant</span>
                         <svg class="w-4 h-4 md:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                         </svg>
                     </span>
                 @endif
            </div>
        </div>
    </div>
@endif