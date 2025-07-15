<x-app-layout>
    <div class="pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 mb-6 shadow-lg">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-lg p-3 mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ __('Centre d\'aide') }}</h2>
                        <p class="text-blue-100 mt-1">{{ __('Guide d\'utilisation de l\'application de gestion des congés') }}</p>
                    </div>
                </div>
            </div>

            <!-- Introduction -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl mb-8">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ __('Bienvenue dans votre application de gestion des congés') }}
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                            {{ __('Ce guide vous aidera à prendre en main rapidement toutes les fonctionnalités de l\'application. Suivez les étapes ci-dessous pour configurer votre profil, gérer vos congés et soumettre vos notes de frais.') }}
                        </p>
                    </div>

                    <!-- Navigation rapide -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                        <a href="#company" class="group bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-xl p-6 border border-cyan-200 dark:border-cyan-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-cyan-100 dark:bg-cyan-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                    {{ __('Informations Société') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Configuration essentielle de votre organisation') }}
                            </p>
                        </a>
                        <a href="#settings" class="group bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                    {{ __('Paramètres') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Configurez votre profil et vos préférences') }}
                            </p>
                        </a>
                        

                        <a href="#users" class="group bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-100 dark:bg-purple-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ __('Gestion des utilisateurs') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Gérez les utilisateurs, départements et équipes') }}
                            </p>
                        </a>

                        <a href="#leaves" class="group bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ __('Congés') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Demandez et gérez vos congés') }}
                            </p>
                        </a>

                        <a href="#dashboard" class="group bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ __('Dashboard') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Comprendre les statistiques et indicateurs') }}
                            </p>
                        </a>

                        <a href="#expenses" class="group bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-center mb-3">
                                <div class="bg-orange-100 dark:bg-orange-900/50 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                    {{ __('Notes de frais') }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Soumettez vos rapports de dépenses') }}
                            </p>
                        </a>

                        
                    </div>
                </div>
            </div>

            <!-- Section Société -->
            <div id="company" class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Informations sur la Société / Structure / Organisme') }}</h2>
                            <p class="text-blue-100 mt-1">{{ __('Configuration essentielle pour votre organisation') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('La configuration des informations de votre société est cruciale pour le bon fonctionnement de l\'application. Ces données sont utilisées pour la génération de documents officiels et la conformité légale.') }}
                        </p>

                        <!-- Importance des informations société -->
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-red-100 dark:bg-red-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                                        {{ __('Important : Configuration obligatoire') }}
                                    </h4>
                                    <p class="text-red-700 dark:text-red-300 mb-2">
                                        {{ __('Il est essentiel de renseigner correctement les informations de votre société pour :') }}
                                    </p>
                                    <ul class="text-red-700 dark:text-red-300 space-y-1">
                                        <li>• {{ __('La génération des contrats de travail') }}</li>
                                        <li>• {{ __('L\'édition des fiches de paie') }}</li>
                                        <li>• {{ __('Les documents officiels de congés') }}</li>
                                        <li>• {{ __('La conformité légale et administrative') }}</li>
                                        <li>• {{ __('L\'identification dans les rapports') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Informations requises -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">1</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Informations de base requises') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Assurez-vous de renseigner les informations suivantes dans les paramètres de la société :') }}
                                    </p>
                                    
                                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mb-4 space-y-2">
                                        <li>{{ __('Nom complet de la société') }}</li>
                                        <li>{{ __('Adresse complète du siège social') }}</li>
                                        <!-- <li>{{ __('Numéro d\'enregistrement (SIRET, SIREN)') }}</li>
                                        <li>{{ __('Code APE/NAF') }}</li> -->
                                        <li>{{ __('Numéro de téléphone principal') }}</li>
                                        <li>{{ __('Adresse e-mail officielle') }}</li>
                                        <li>{{ __('Site web (optionnel)') }}</li>
                                        <li>{{ __('Logo de l\'entreprise') }}</li>
                                    </ul>
                                    <!-- On se base sur le pays pour mettre le bon currency -->
                                </div>
                            </div>
                        </div>

                        <!-- Accès aux paramètres -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">2</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Accéder aux paramètres de la société') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Pour configurer les informations de votre société :') }}
                                    </p>
                                    
                                    <ol class="list-decimal list-inside text-gray-600 dark:text-gray-400 mb-4 space-y-2">
                                        <li>{{ __('Connectez-vous avec un compte administrateur') }}</li>
                                        <li>{{ __('Accédez au menu "Paramètres" dans la barre de navigation') }}</li>
                                        <li>{{ __('Sélectionnez "Informations de la société"') }}</li>
                                        <li>{{ __('Remplissez tous les champs obligatoires') }}</li>
                                        <li>{{ __('Sauvegardez vos modifications') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils de sécurité -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                        {{ __('Bonnes pratiques') }}
                                    </h4>
                                    <ul class="text-blue-700 dark:text-blue-300 space-y-1">
                                        <li>• {{ __('Vérifiez l\'exactitude de toutes les informations légales') }}</li>
                                        <li>• {{ __('Mettez à jour les informations en cas de changement') }}</li>
                                        <li>• {{ __('Utilisez un logo en haute résolution (PNG ou SVG)') }}</li>
                                        <li>• {{ __('Conservez une copie de sauvegarde de vos paramètres') }}</li>
                                        <li>• {{ __('Testez la génération de documents après configuration') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Paramètres -->
            <div id="settings" class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl mb-8">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Configuration des paramètres') }}</h2>
                            <p class="text-green-100 mt-1">{{ __('Personnalisez votre profil et vos préférences') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('La configuration de vos paramètres est essentielle pour une utilisation optimale de l\'application. Suivez ce guide étape par étape pour configurer votre profil.') }}
                        </p>

                        <!-- Étape 1 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">1</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Accéder à vos paramètres') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Pour accéder à vos paramètres, cliquez sur votre avatar en haut à droite de l\'écran, puis sélectionnez "Profil" dans le menu déroulant.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Menu utilisateur') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">2</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Compléter vos informations personnelles') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Remplissez tous les champs obligatoires de votre profil :') }}
                                    </p>
                                    
                                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mb-4 space-y-2">
                                        <li>{{ __('Prénom et nom de famille') }}</li>
                                        <li>{{ __('Adresse e-mail professionnelle') }}</li>
                                        <li>{{ __('Numéro de téléphone') }}</li>
                                        <li>{{ __('Genre (optionnel)') }}</li>
                                        <li>{{ __('Département') }}</li>
                                        <li>{{ __('Poste occupé') }}</li>
                                    </ul>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de profil') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">3</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Modifier votre mot de passe') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Pour des raisons de sécurité, il est recommandé de changer votre mot de passe initial. Utilisez un mot de passe fort contenant au moins 8 caractères avec des lettres, chiffres et symboles.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Changement de mot de passe') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 4 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">4</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Sauvegarder vos modifications') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('N\'oubliez pas de cliquer sur le bouton "Mettre à jour" pour sauvegarder toutes vos modifications. Un message de confirmation apparaîtra pour vous indiquer que vos informations ont été mises à jour avec succès.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Confirmation de sauvegarde') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils supplémentaires -->
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                                        {{ __('Conseils utiles') }}
                                    </h4>
                                    <ul class="text-green-700 dark:text-green-300 space-y-1">
                                        <li>• {{ __('Vérifiez régulièrement que vos informations sont à jour') }}</li>
                                        <li>• {{ __('Utilisez une adresse e-mail que vous consultez fréquemment') }}</li>
                                        <li>• {{ __('Contactez votre administrateur si vous ne trouvez pas votre département') }}</li>
                                        <li>• {{ __('Activez l\'authentification à deux facteurs pour plus de sécurité') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Dashboard -->
            <div id="dashboard" class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl mb-8">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Comprendre le Dashboard') }}</h2>
                            <p class="text-indigo-100 mt-1">{{ __('Guide des statistiques et indicateurs de performance') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('Le dashboard administrateur vous offre une vue d\'ensemble complète de l\'activité de votre organisation. Découvrez comment interpréter chaque élément pour optimiser la gestion de vos équipes.') }}
                        </p>

                        <!-- Indicateurs principaux -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">📊</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Indicateurs clés de performance (KPI)') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Les quatre cartes principales en haut du dashboard affichent les métriques essentielles :') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></div>
                                                <h4 class="font-semibold text-emerald-800 dark:text-emerald-200">{{ __('Total employés') }}</h4>
                                            </div>
                                            <p class="text-sm text-emerald-700 dark:text-emerald-300">
                                                {{ __('Nombre d\'employés actifs dans l\'organisation. Indicateur de la taille de votre équipe.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                                <h4 class="font-semibold text-blue-800 dark:text-blue-200">{{ __('Total congés') }}</h4>
                                            </div>
                                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                                {{ __('Nombre total de demandes de congés soumises. Permet de suivre l\'activité des demandes.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-800 rounded-lg p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-3 h-3 bg-teal-500 rounded-full mr-2"></div>
                                                <h4 class="font-semibold text-teal-800 dark:text-teal-200">{{ __('Total notes de frais') }}</h4>
                                            </div>
                                            <p class="text-sm text-teal-700 dark:text-teal-300">
                                                {{ __('Montant total des notes de frais du mois en cours. Essentiel pour le suivi budgétaire.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 rounded-lg p-4">
                                            <div class="flex items-center mb-2">
                                                <div class="w-3 h-3 bg-rose-500 rounded-full mr-2"></div>
                                                <h4 class="font-semibold text-rose-800 dark:text-rose-200">{{ __('Masse salariale') }}</h4>
                                            </div>
                                            <p class="text-sm text-rose-700 dark:text-rose-300">
                                                {{ __('Coût total des salaires de l\'organisation. Indicateur financier majeur pour la gestion RH.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Graphiques et analyses -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">📈</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Graphiques et analyses visuelles') }}
                                    </h3>
                                    
                                    <div class="space-y-6">
                                        <div class="border-l-4 border-yellow-400 pl-4">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Graphique en donut - Statut des congés') }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                                {{ __('Répartition des demandes de congés par statut (En attente, Approuvés, Rejetés). Permet d\'identifier rapidement les demandes nécessitant une action.') }}
                                            </p>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li>• <span class="text-yellow-600 font-medium">{{ __('Jaune') }}</span> : {{ __('Demandes en attente de validation') }}</li>
                                                <li>• <span class="text-green-600 font-medium">{{ __('Vert') }}</span> : {{ __('Demandes approuvées') }}</li>
                                                <li>• <span class="text-red-600 font-medium">{{ __('Rouge') }}</span> : {{ __('Demandes rejetées') }}</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="border-l-4 border-teal-400 pl-4">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Graphique en barres - Congés par département') }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                {{ __('Comparaison du nombre de jours de congés pris par département. Utile pour identifier les départements avec une charge de travail élevée ou des besoins de renfort.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="border-l-4 border-green-400 pl-4">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Graphique linéaire - Évolution mensuelle') }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                {{ __('Tendance des congés sur l\'année. Permet d\'anticiper les périodes de forte demande et de planifier les ressources en conséquence.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistiques détaillées -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">👥</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Répartition des utilisateurs par rôle') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Cette section détaille la composition de votre organisation par type d\'utilisateur :') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Total employés') }}</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Managers') }}</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                                            <div class="w-3 h-3 bg-purple-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Administrateurs') }}</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                                            <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Chefs de département') }}</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                                            <div class="w-3 h-3 bg-cyan-400 rounded-full mr-3"></div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Ressources Humaines') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activités récentes -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">🕒</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Tableaux d\'activités récentes') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Deux tableaux vous permettent de suivre l\'activité en temps réel :') }}
                                    </p>
                                    
                                    <div class="space-y-4">
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Dernières demandes de congés') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                {{ __('Affiche les demandes les plus récentes avec :') }}
                                            </p>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li>• {{ __('Date de soumission') }}</li>
                                                <li>• {{ __('Type de congé (annuel, maladie, sans solde, autre)') }}</li>
                                                <li>• {{ __('Informations de l\'employé') }}</li>
                                                <li>• {{ __('Statut actuel avec badges colorés') }}</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Dernières notes de frais') }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                {{ __('Suivi des notes de frais récentes avec :') }}
                                            </p>
                                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <li>• {{ __('Date de création') }}</li>
                                                <li>• {{ __('Employé concerné') }}</li>
                                                <li>• {{ __('Montant total') }}</li>
                                                <li>• {{ __('Statut (brouillon, soumis, approuvé, rejeté, payé)') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils d'utilisation -->
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-indigo-800 dark:text-indigo-200 mb-2">
                                        {{ __('Conseils pour optimiser l\'utilisation du dashboard') }}
                                    </h4>
                                    <ul class="text-indigo-700 dark:text-indigo-300 space-y-1">
                                        <li>• {{ __('Consultez le dashboard quotidiennement pour rester informé des activités') }}</li>
                                        <li>• {{ __('Utilisez les graphiques pour identifier les tendances et anticiper les besoins') }}</li>
                                        <li>• {{ __('Surveillez les demandes en attente pour maintenir un bon niveau de service') }}</li>
                                        <li>• {{ __('Analysez la répartition par département pour équilibrer les charges de travail') }}</li>
                                        <li>• {{ __('Suivez l\'évolution mensuelle pour planifier les périodes de congés') }}</li>
                                        <li>• {{ __('Utilisez les liens "Voir toutes" pour accéder aux vues détaillées') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Gestion des utilisateurs -->
            <div id="users" class="bg-white dark:bg-gray-800 overflow-hidden rounded-xl mb-8">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Gestion des utilisateurs') }}</h2>
                            <p class="text-purple-100 mt-1">{{ __('Gérez les utilisateurs, départements et équipes') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('Cette section vous guide dans la gestion des utilisateurs, des départements et des équipes de votre organisation. Suivez ces étapes pour administrer efficacement votre système.') }}
                        </p>

                        <!-- Gestion des utilisateurs -->
                        <div class="mb-12">
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <span class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">1</span>
                                {{ __('Gestion des utilisateurs') }}
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Créer un nouvel utilisateur') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Accédez au menu "Utilisateurs" puis cliquez sur "Ajouter un utilisateur". Remplissez les informations requises : nom, prénom, email, rôle, département et équipe.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de création d\'utilisateur') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Modifier un utilisateur existant') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Dans la liste des utilisateurs, cliquez sur l\'icône d\'édition. Vous pouvez modifier les informations personnelles, le rôle, le département et l\'équipe.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Liste des utilisateurs avec boutons d\'action') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Gérer les rôles et permissions') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Assignez les rôles appropriés : Employé, Manager, RH ou Admin. Chaque rôle a des permissions spécifiques pour accéder aux différentes fonctionnalités.') }}
                                    </p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 text-center">
                                            <span class="text-blue-800 dark:text-blue-200 font-medium text-sm">{{ __('Employé') }}</span>
                                        </div>
                                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center">
                                            <span class="text-green-800 dark:text-green-200 font-medium text-sm">{{ __('Manager') }}</span>
                                        </div>
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 text-center">
                                            <span class="text-yellow-800 dark:text-yellow-200 font-medium text-sm">{{ __('RH') }}</span>
                                        </div>
                                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 text-center">
                                            <span class="text-red-800 dark:text-red-200 font-medium text-sm">{{ __('Admin') }}</span>
                                        </div>
                                    </div>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Sélection des rôles utilisateur') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gestion des départements -->
                        <div class="mb-12">
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <span class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">2</span>
                                {{ __('Gestion des départements') }}
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Créer un département') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Accédez au menu "Départements" et cliquez sur "Ajouter un département". Définissez le nom, la description et assignez un chef de département.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de création de département') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Assigner des utilisateurs') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Lors de la création ou modification d\'un utilisateur, sélectionnez le département approprié. Vous pouvez également modifier en masse les affectations.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Affectation d\'utilisateurs à un département') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gestion des équipes -->
                        <div class="mb-8">
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <span class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">3</span>
                                {{ __('Gestion des équipes') }}
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Créer une équipe') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Dans le menu "Équipes", créez une nouvelle équipe en définissant son nom, sa description et en sélectionnant les membres.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de création d\'équipe') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Gérer les membres d\'équipe') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ __('Ajoutez ou retirez des membres, assignez des rôles spécifiques au sein de l\'équipe et gérez les permissions d\'accès aux projets.') }}
                                    </p>
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Gestion des membres d\'équipe') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils et bonnes pratiques -->
                        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-purple-100 dark:bg-purple-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-2">
                                        {{ __('Conseils pour la gestion des utilisateurs') }}
                                    </h4>
                                    <ul class="text-purple-700 dark:text-purple-300 space-y-1">
                                        <li>• {{ __('Définissez une structure organisationnelle claire avant de créer les départements') }}</li>
                                        <li>• {{ __('Assignez les rôles avec parcimonie pour maintenir la sécurité') }}</li>
                                        <li>• {{ __('Utilisez les équipes pour organiser les projets transversaux') }}</li>
                                        <li>• {{ __('Révisez régulièrement les permissions et les affectations') }}</li>
                                        <li>• {{ __('Documentez les changements organisationnels importants') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Congés -->
            <div id="leaves" class="bg-white dark:bg-gray-800 overflow-hidden  rounded-xl mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Gestion des congés') }}</h2>
                            <p class="text-blue-100 mt-1">{{ __('Demandez et suivez vos congés facilement') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('La gestion des congés vous permet de soumettre des demandes, suivre leur statut et consulter votre solde de congés. Voici comment procéder étape par étape.') }}
                        </p>

                        <!-- Étape 1 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">1</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Accéder au module congés') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Dans le menu principal, cliquez sur "Congés" pour accéder au tableau de bord des congés. Vous y verrez vos demandes récentes et votre solde de congés disponible.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Tableau de bord des congés') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">2</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Créer une nouvelle demande') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Cliquez sur le bouton "Nouvelle demande" pour ouvrir le formulaire de demande de congé. Remplissez les informations suivantes :') }}
                                    </p>
                                    
                                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mb-4 space-y-2">
                                        <li>{{ __('Type de congé (congés payés, maladie, maternité/paternité, etc.)') }}</li>
                                        <li>{{ __('Date de début et date de fin') }}</li>
                                        <li>{{ __('Motif de la demande') }}</li>
                                        <li>{{ __('Pièces justificatives (si nécessaire)') }}</li>
                                    </ul>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de demande de congé') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">3</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Suivre le statut de votre demande') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Une fois votre demande soumise, vous pouvez suivre son statut dans la liste de vos demandes. Les statuts possibles sont :') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-yellow-100 dark:bg-yellow-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-yellow-800 dark:text-yellow-200 font-medium">{{ __('En attente') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-green-800 dark:text-green-200 font-medium">{{ __('Approuvé') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-red-100 dark:bg-red-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-red-800 dark:text-red-200 font-medium">{{ __('Refusé') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-blue-800 dark:text-blue-200 font-medium">{{ __('En cours') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Liste des demandes avec statuts') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 4 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">4</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Consulter votre solde de congés') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Votre solde de congés est affiché en permanence dans le tableau de bord. Il indique le nombre de jours disponibles par type de congé et se met à jour automatiquement après validation de vos demandes.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Solde de congés') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Types de congés -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                        {{ __('Types de congés disponibles') }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-blue-700 dark:text-blue-300">
                                        <div>• {{ __('Congés payés annuels') }}</div>
                                        <div>• {{ __('Congé maladie') }}</div>
                                        <div>• {{ __('Congé maternité/paternité') }}</div>
                                        <div>• {{ __('Congé sans solde') }}</div>
                                        <div>• {{ __('Formation professionnelle') }}</div>
                                        <div>• {{ __('Récupération d\'heures') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils supplémentaires -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                        {{ __('Conseils pour vos demandes de congés') }}
                                    </h4>
                                    <ul class="text-blue-700 dark:text-blue-300 space-y-1">
                                        <li>• {{ __('Soumettez vos demandes au moins 2 semaines à l\'avance') }}</li>
                                        <li>• {{ __('Vérifiez votre solde avant de faire une demande') }}</li>
                                        <li>• {{ __('Joignez les justificatifs nécessaires (certificat médical, etc.)') }}</li>
                                        <li>• {{ __('Évitez les périodes de forte activité de votre équipe') }}</li>
                                        <li>• {{ __('Contactez votre manager en cas d\'urgence') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Notes de frais -->
            <div id="expenses" class="bg-white dark:bg-gray-800 overflow-hidden  rounded-xl mb-8">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 rounded-lg p-3 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ __('Gestion des notes de frais') }}</h2>
                            <p class="text-green-100 mt-1">{{ __('Soumettez et suivez vos remboursements facilement') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="prose max-w-none dark:prose-invert">
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('Le module de notes de frais vous permet de soumettre vos demandes de remboursement, joindre les justificatifs et suivre le traitement de vos dossiers. Voici comment procéder étape par étape.') }}
                        </p>

                        <!-- Étape 1 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">1</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Accéder au module notes de frais') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Dans le menu principal, cliquez sur "Notes de frais" pour accéder au tableau de bord. Vous y verrez vos notes de frais récentes et pourrez créer une nouvelle demande.') }}
                                    </p>
                                    
                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Tableau de bord des notes de frais') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">2</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Créer une nouvelle note de frais') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Cliquez sur "Nouvelle note de frais" et remplissez les informations générales :') }}
                                    </p>
                                    
                                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 mb-4 space-y-2">
                                        <li>{{ __('Titre de la note de frais') }}</li>
                                        <li>{{ __('Description générale') }}</li>
                                        <li>{{ __('Période concernée') }}</li>
                                        <li>{{ __('Projet ou département (si applicable)') }}</li>
                                    </ul>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Formulaire de création de note de frais') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">3</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Ajouter les lignes de frais') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Pour chaque frais, ajoutez une ligne avec les détails suivants :') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                            <h4 class="font-semibold text-green-800 dark:text-green-200 mb-2">{{ __('Informations obligatoires') }}</h4>
                                            <ul class="text-green-700 dark:text-green-300 text-sm space-y-1">
                                                <li>• {{ __('Date de la dépense') }}</li>
                                                <li>• {{ __('Catégorie (transport, repas, etc.)') }}</li>
                                                <li>• {{ __('Montant TTC') }}</li>
                                                <li>• {{ __('Description détaillée') }}</li>
                                            </ul>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                            <h4 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">{{ __('Informations optionnelles') }}</h4>
                                            <ul class="text-blue-700 dark:text-blue-300 text-sm space-y-1">
                                                <li>• {{ __('Montant HT et TVA') }}</li>
                                                <li>• {{ __('Devise (si différente)') }}</li>
                                                <li>• {{ __('Kilométrage (pour transport)') }}</li>
                                                <li>• {{ __('Participants (pour repas)') }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Ajout de lignes de frais') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 4 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">4</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Joindre les justificatifs') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Pour chaque ligne de frais, joignez les justificatifs correspondants. Les formats acceptés sont PDF, JPG, PNG.') }}
                                    </p>
                                    
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-4">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-1">{{ __('Important') }}</h4>
                                                <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                                                    {{ __('Les justificatifs sont obligatoires pour tous les frais supérieurs à 25 ' . $globalCompanyCurrency . '. Assurez-vous que les documents sont lisibles et complets.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Upload de justificatifs') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 5 -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 mr-4 mt-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold text-lg">5</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        {{ __('Soumettre et suivre votre note de frais') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ __('Une fois toutes les lignes ajoutées, soumettez votre note de frais. Vous pouvez suivre son statut dans la liste de vos notes de frais :') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-gray-100 dark:bg-gray-600 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ __('Brouillon') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-yellow-100 dark:bg-yellow-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-yellow-800 dark:text-yellow-200 font-medium">{{ __('En attente') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-blue-800 dark:text-blue-200 font-medium">{{ __('En cours de traitement') }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                            <div class="flex items-center">
                                                <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-1 mr-2">
                                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-green-800 dark:text-green-200 font-medium">{{ __('Approuvé') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Placeholder pour capture d'écran -->
                                    <div class="bg-gray-200 dark:bg-gray-600 rounded-lg p-8 text-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ __('Capture d\'écran : Suivi des notes de frais') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catégories de frais -->
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-8">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                                        {{ __('Catégories de frais courantes') }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-green-700 dark:text-green-300">
                                        <div>• {{ __('Transport (train, avion, taxi)') }}</div>
                                        <div>• {{ __('Hébergement (hôtel)') }}</div>
                                        <div>• {{ __('Repas d\'affaires') }}</div>
                                        <div>• {{ __('Carburant et péage') }}</div>
                                        <div>• {{ __('Fournitures de bureau') }}</div>
                                        <div>• {{ __('Télécommunications') }}</div>
                                        <div>• {{ __('Formation et séminaires') }}</div>
                                        <div>• {{ __('Frais de représentation') }}</div>
                                        <div>• {{ __('Autres frais professionnels') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conseils supplémentaires -->
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="bg-green-100 dark:bg-green-900/50 rounded-lg p-2 mr-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                                        {{ __('Conseils pour vos notes de frais') }}
                                    </h4>
                                    <ul class="text-green-700 dark:text-green-300 space-y-1">
                                        <li>• {{ __('Conservez tous vos justificatifs pendant vos déplacements') }}</li>
                                        <li>• {{ __('Soumettez vos notes de frais dans les 30 jours suivant la dépense') }}</li>
                                        <li>• {{ __('Vérifiez les plafonds de remboursement selon votre politique d\'entreprise') }}</li>
                                        <li>• {{ __('Utilisez l\'application mobile pour scanner vos reçus en temps réel') }}</li>
                                        <li>• {{ __('Séparez les frais personnels des frais professionnels') }}</li>
                                        <li>• {{ __('Contactez la comptabilité en cas de doute sur une catégorie') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>