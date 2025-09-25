@section('title', 'Import en masse d\'utlisateurs')
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                                Import en masse d'utilisateurs
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 sm:mt-2 text-base sm:text-lg">Importez plusieurs utilisateurs à la fois via un fichier Excel</p>
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

        <!-- Messages d'alerte -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-yellow-800 dark:text-yellow-200 font-medium">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
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
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Utilisez notre modèle pré-formaté avec des exemples</p>
                            </div>
                        </div>
                        
                        <div class="group/step flex items-start space-x-4 p-4 rounded-xl hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full blur opacity-20 group-hover/step:opacity-40 transition-opacity"></div>
                                <span class="relative flex-shrink-0 w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">2</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Remplissez les données</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Supprimez les exemples et ajoutez vos utilisateurs</p>
                            </div>
                        </div>
                        
                        <div class="group/step flex items-start space-x-4 p-4 rounded-xl hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all duration-300">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full blur opacity-20 group-hover/step:opacity-40 transition-opacity"></div>
                                <span class="relative flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">3</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-lg">Importez le fichier</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Sélectionnez votre fichier et lancez l'import</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200/50 dark:border-blue-700/50">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-indigo-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-4">
                                    <div class="p-1 bg-blue-500 rounded-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-blue-900 dark:text-blue-100 text-lg">Colonnes requises</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-2">
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>prenom</strong> : Prénom de l'utilisateur</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>nom</strong> : Nom de famille</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>sexe</strong> : M/F ou Masculin/Féminin</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>email</strong> : Adresse email unique</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>poste</strong> : Fonction/poste</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>role</strong> : employee, manager, admin, hr, department_head</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-blue-800 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                        <span><strong>departement</strong> : Nom du département existant</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-gray-50 to-slate-50 dark:from-gray-800/50 dark:to-slate-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-400/10 to-slate-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="relative">
                                <div class="flex items-center space-x-2 mb-4">
                                    <div class="p-1 bg-gray-500 rounded-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-lg">Colonnes optionnelles</h3>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <div class="space-y-3">
                                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600 pb-1">Informations de base</h5>
                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>telephone</strong> : Numéro de téléphone</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>mot_de_passe</strong> : Mot de passe (défaut: password123)</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>prestataire</strong> : oui/non (défaut: non)</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>date_naissance</strong> : Date de naissance (YYYY-MM-DD)</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>adresse</strong> : Adresse complète</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600 pb-1">Informations personnelles</h5>
                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>etat_civil</strong> : marié, célibataire, veuf</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>nombre_enfants</strong> : Nombre d'enfants (0-20)</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>contact_urgence_nom</strong> : Nom du contact d'urgence</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>contact_urgence_telephone</strong> : Téléphone du contact</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>contact_urgence_relation</strong> : Relation (père/mère/frère/etc.)</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3 lg:col-span-2">
                                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600 pb-1">Informations professionnelles</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>statut_professionnel</strong> : fonctionnaire, contractuel_cdi, contractuel_cdd</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>matricule</strong> : Matricule unique</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>categorie</strong> : cadre, agent_de_maitrise, employe, ouvrier</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>affectation</strong> : Affectation de l'employé</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>section</strong> : Section de travail</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>service</strong> : Service de travail</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>date_entree</strong> : Date d'entrée (YYYY-MM-DD)</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                <span><strong>date_sortie</strong> : Date de sortie (YYYY-MM-DD)</span>
                                            </div>
                                        </div>
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
                            Import des utilisateurs
                        </h2>
                    </div>

                    <!-- Télécharger le modèle moderne -->
                    <div class="mb-8">
                        <a href="{{ route('admin.users.download-template') }}" 
                           class="group/download relative overflow-hidden inline-flex items-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 border border-transparent rounded-2xl font-bold text-white transition-all duration-300 shadow-lg hover:shadow-xl w-full justify-center transform hover:scale-105">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/download:translate-x-full transition-transform duration-700"></div>
                            <svg class="w-6 h-6 mr-3 transition-transform group-hover/download:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="relative">Télécharger le modèle Excel</span>
                        </a>
                    </div>

                    <!-- Formulaire d'upload -->
                    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6" 
                          x-data="{ loading: false }" 
                          @submit="loading = true"
                          @submit.prevent="
                            loading = true;
                            $el.submit();
                            // Reset loading state after a timeout in case of error
                            setTimeout(() => { loading = false; }, 30000);
                          ">
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
                                :disabled="loading"
                                class="group/submit relative overflow-hidden w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover/submit:translate-x-full transition-transform duration-700"></div>
                            
                            <!-- Icône normale (visible quand pas de chargement) -->
                            <svg x-show="!loading" class="w-6 h-6 mr-3 transition-transform group-hover/submit:scale-110 group-hover/submit:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            
                            <!-- Spinner animé (visible pendant le chargement) -->
                            <svg x-show="loading" class="animate-spin w-6 h-6 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            
                            <!-- Texte du bouton -->
                            <span class="relative" x-show="!loading">Importer les utilisateurs</span>
                            <span class="relative" x-show="loading">Importation en cours...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Pré-requis avant l'importation -->
        <div class="mt-8 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 backdrop-blur-xl rounded-2xl shadow-xl border border-amber-200/50 dark:border-amber-700/50">
            <div class="px-8 py-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="p-2 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-amber-700 dark:text-amber-400">
                        Pré-requis avant l'importation
                    </h2>
                </div>
                
                <div class="space-y-4">
                    <p class="text-amber-800 dark:text-amber-300 text-lg font-medium mb-6">
                        Avant de procéder à l'importation des utilisateurs, assurez-vous d'avoir complété les étapes suivantes :
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-white/60 dark:bg-gray-800/60 rounded-xl border border-amber-200/30 dark:border-amber-700/30">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                1
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-300 mb-2">
                                    Remplir les informations de la société
                                </h3>
                                <p class="text-amber-700 dark:text-amber-400">
                                    Configurez les informations de base de votre entreprise dans les paramètres système avant d'importer les utilisateurs.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-white/60 dark:bg-gray-800/60 rounded-xl border border-amber-200/30 dark:border-amber-700/30">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                2
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-300 mb-2">
                                    Créer les entités (départements)
                                </h3>
                                <p class="text-amber-700 dark:text-amber-400">
                                    Créez tous les départements nécessaires dans la section "Départements" avant d'importer les utilisateurs pour éviter les erreurs de référence.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-amber-100/50 dark:bg-amber-900/30 rounded-xl border border-amber-300/50 dark:border-amber-600/50">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-amber-700 dark:text-amber-300 font-medium">
                                Important :
                            </span>
                        </div>
                        <p class="text-amber-700 dark:text-amber-400 mt-2">
                            Le non-respect de ces pré-requis peut entraîner des erreurs lors de l'importation et nécessiter une correction manuelle des données.
                        </p>
                    </div>
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