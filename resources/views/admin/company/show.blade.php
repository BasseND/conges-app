<x-app-layout>

    <div class="w-full px-4">
        <!-- <div class="flex flex-col">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 sm:mb-0">Informations de la société</h4>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('welcome.index') }}" class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">Accueil</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="text-gray-500 dark:text-gray-400">Société</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div> -->
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        @endif

        <div class="flex flex-col">
            <div class="w-full">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h2 class="text-bgray-900 dark:text-white sm:text-2xl text-xl font-bold">
                                {{ __('Informations de la société') }}
                            </h2>
                            @if($company)
                                <a href="{{ route('admin.company.edit') }}" class="inline-flex items-center btn btn-primary">
                                    <i class="bx bx-edit-alt mr-1"></i> Modifier
                                </a>
                            @else
                                <a href="{{ route('admin.company.create') }}" class="inline-flex items-center btn btn-primary">
                                    <i class="bx bx-plus mr-1"></i> Créer
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                    
                        @if($company)
                            <div class="bg-gray-50 dark:bg-dark-card-two rounded-xl p-7 border border-gray-100">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                    <div class="lg:col-span-4">
                                        <div class="text-center">
                                            @if($company->logo)
                                                <img src="{{ Storage::url($company->logo) }}" alt="Logo de la société" class="max-w-full h-auto rounded-lg max-h-48 mx-auto">
                                            @else
                                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center h-48">
                                                    <i class="bx bx-building text-gray-400 text-6xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="lg:col-span-8">
                                        <div class="grid md:grid-cols-2 gap-x-12 gap-y-4">
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Nom :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->name }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Adresse :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->address }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Ville :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->city }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Code postal :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->postal_code }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Pays :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->country }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Email :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->contact_email }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Téléphone :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->contact_phone }}</span>
                                            </div>
                                            <div class="flex  sm:items-center flex-start flex-col sm:flex-row dark:text-dark-text-two gap-2">
                                                <span class="font-bold text-gray-700 dark:text-dark-text w-32">Site web :</span>
                                                <span class="text-base font-medium text-bgray-600 dark:text-bgray-50">{{ $company->website }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="bx bx-building text-gray-400 text-6xl"></i>
                                <h5 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucune information de société configurée</h5>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Cliquez sur le bouton "Créer" pour ajouter les informations de votre société.</p>
                                <a href="{{ route('admin.company.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                    <i class="bx bx-plus mr-1"></i> Créer les informations de la société
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
