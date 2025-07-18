@section('title', 'Accès non autorisé')

<x-guest-layout>
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="max-w-7xl mx-auto mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center">
                <div class="flex justify-center">
                  <img src="{{ asset('images/illustration/403_page.webp') }}" class="block w-auto h-52 mb-4" alt="Image 404">
                </div>
                <h1 class="text-2xl font-semibold text-gray-900 mb-2">Accès non autorisé</h1>
                <p class="text-gray-600 mb-8">Désolé, vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
                
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('leaves.index') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 border border-transparent rounded-xl font-semibold text-white transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Retour à l'accueil
                    </a>
                    <button onclick="window.history.back()" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Page précédente
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
