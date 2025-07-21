<x-app-layout>

    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto md:px-8">

            <!-- En-tête moderne -->
            <div class="bg-white dark:bg-gray-800/80 relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 mb-8">
                <div class="relative px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 lg:space-x-6">
                            <div class="relative flex-shrink-0 self-center sm:self-auto">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-20 animate-pulse"></div>
                                <div class="relative p-3 sm:p-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-center sm:text-left">
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                                    Import des entités
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1 sm:mt-2 text-base sm:text-lg">Importez facilement vos entités en masse avec notre système d'import Excel/CSV avancé</p>
                            </div>
                        </div>
                        <div class="flex justify-center lg:justify-end">
                            <a href="{{ route('admin.users.index') }}" 
                            class="group inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-white/80 hover:bg-white dark:bg-gray-700/80 dark:hover:bg-gray-700 border border-gray-200/50 dark:border-gray-600/50 rounded-xl font-medium text-gray-700 dark:text-gray-300 transition-all duration-300 hover:shadow-lg hover:scale-105">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="text-sm sm:text-base">Retour</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


             <!-- Messages d'alerte modernes -->
            @if(session('success'))
                <div class="mb-8 group bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-green-200/50 dark:border-green-700/50 shadow-xl">
                    <div class="px-8 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-green-800 dark:text-green-200">Succès !</h3>
                                <p class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-8 group bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-yellow-200/50 dark:border-yellow-700/50 shadow-xl">
                    <div class="px-8 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-2 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200">Attention !</h3>
                                <p class="text-yellow-700 dark:text-yellow-300 font-medium">{{ session('warning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 group bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-red-200/50 dark:border-red-700/50 shadow-xl">
                    <div class="px-8 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-2 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-red-800 dark:text-red-200">Erreur !</h3>
                                <p class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Instructions modernes -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-500">
               
                 <div class="px-8 py-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            Instructions d'import
                        </h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="group/step flex items-start space-x-4 p-4 rounded-xl hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur opacity-20 group-hover/step:opacity-40 transition-opacity"></div>
                                <span class="relative flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">1</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Téléchargez le modèle Excel</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Téléchargez le modèle Excel pré-formaté avec toutes les colonnes nécessaires</p>
                            </div>
                        </div>
                        
                        <div class="group/step flex items-start space-x-4 p-4 rounded-xl hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full blur opacity-20 group-hover/step:opacity-40 transition-opacity"></div>
                                <span class="relative flex-shrink-0 w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">2</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Remplissez les données</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Complétez le fichier avec les informations de vos entités</p>
                            </div>
                        </div>
                        
                        <div class="group/step flex items-start space-x-4 p-4 rounded-xl hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full blur opacity-20 group-hover/step:opacity-40 transition-opacity"></div>
                                <span class="relative flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">3</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Importez le fichier</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Uploadez votre fichier et laissez notre système traiter l'importation</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200/50 dark:border-blue-700/50">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-indigo-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="relative">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="p-2 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        Colonnes requises
                                    </h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span><strong>nom</strong> : Nom de l'entité</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span><strong>code</strong> : Code unique de l'entité</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span><strong>societe</strong> : Nom de la société</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-gray-50 to-slate-50 dark:from-gray-800/50 dark:to-slate-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-400/10 to-slate-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="relative">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        Colonnes optionnelles
                                    </h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                        <span><strong>description</strong> : Description de l'entité</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                        <span><strong>email_chef</strong> : Email du chef de l'entité</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                        <span><strong>solde_conges</strong> : Nom du solde de congés</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            
            
            
            
            
               
            </div>
            <!-- Formulaire d'import moderne -->
            <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-500">
                 <div class="px-8 py-8">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            Import des entités
                        </h2>
                    </div>

                    <!-- Télécharger le modèle moderne -->
                    <div class="mb-8">
                        <a href="{{ route('admin.departments.download-template') }}" 
                           class="group/download relative overflow-hidden inline-flex items-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 border border-transparent rounded-2xl font-bold text-white transition-all duration-300 shadow-lg hover:shadow-xl w-full justify-center transform hover:scale-105">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/download:translate-x-full transition-transform duration-700"></div>
                            <svg class="w-6 h-6 mr-3 transition-transform group-hover/download:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="relative">Télécharger le modèle Excel</span>
                        </a>
                    </div>

                    <!-- Formulaire d'upload -->
                    <form action="{{ route('admin.departments.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="file" class="block text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                Fichier Excel/CSV
                            </label>
                            <div class="relative group/upload">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 rounded-2xl blur opacity-0 group-hover/upload:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative mt-1 flex justify-center px-8 pt-8 pb-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 bg-gradient-to-br from-gray-50/50 to-blue-50/50 dark:from-gray-800/50 dark:to-blue-900/20 group-hover/upload:from-blue-50 group-hover/upload:to-indigo-50 dark:group-hover/upload:from-blue-900/30 dark:group-hover/upload:to-indigo-900/30">
                                    <div class="space-y-4 text-center">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur opacity-20 group-hover/upload:opacity-40 transition-opacity"></div>
                                            <div class="relative mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg group-hover/upload:scale-110 transition-transform duration-300">
                                                <svg class="h-8 w-8 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex text-lg text-gray-600 dark:text-gray-400">
                                            <label for="file" class="relative cursor-pointer bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl px-4 py-2 font-bold text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-all duration-300 hover:scale-105 shadow-lg">
                                                <span>Sélectionner un fichier</span>
                                                <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                            </label>
                                            <p class="pl-2 self-center font-medium">ou glisser-déposer</p>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                            Excel (.xlsx, .xls) ou CSV jusqu'à 2MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="group/submit relative overflow-hidden w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/submit:translate-x-full transition-transform duration-700"></div>
                            <svg class="w-6 h-6 mr-3 transition-transform group-hover/submit:scale-110 group-hover/submit:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span class="relative">Importer les entités</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Erreurs d'import modernes -->
            @if(session('import_errors'))
                <div class="mt-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-red-200/50 dark:border-red-700/50">
                    <div class="px-8 py-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-red-600 dark:text-red-400">
                                Erreurs d'import
                            </h2>
                        </div>
                        
                        <div class="overflow-x-auto rounded-xl border border-red-200/50 dark:border-red-700/50">
                            <table class="min-w-full divide-y divide-red-200 dark:divide-red-700">
                                <thead class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Ligne</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Erreur</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Données</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/50 dark:bg-gray-800/50 divide-y divide-red-100 dark:divide-red-800">
                                    @foreach(session('import_errors') as $error)
                                        <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200">
                                                    {{ $error['row'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-red-600 dark:text-red-400">
                                                {{ $error['error'] }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 font-mono bg-gray-50 dark:bg-gray-700/50 rounded">
                                                {{ json_encode($error['data']) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif











        </div>
    </div>


</div>

<script>
// Améliorer l'UX du drag & drop
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('file');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropZone.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            updateFileName(files[0].name);
        }
    }
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            updateFileName(this.files[0].name);
        }
    });
    
    function updateFileName(name) {
        const label = dropZone.querySelector('label span');
        label.textContent = name;
        label.classList.add('text-green-600', 'dark:text-green-400');
    }
});
</script>
</x-app-layout>