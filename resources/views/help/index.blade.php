<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aide') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                     <h2 class="text-lg font-semibold mb-4">Comment utiliser l'application de gestion des congés</h2>

                        <div class="w-full px-5">
                            <ul>
                                <li class="flex pb-10 mb-8 border-b border-gray-200 dark:border-gray-700">
                                <div class="mr-8">
                                    <span class="flex justify-center items-center w-14 h-14 bg-blue-200/50 dark:bg-blue-600/30 text-lg font-bold rounded-full text-blue-600 dark:text-blue-300">1</span>
                                </div>
                                <div class="">
                                    <h3 class="mb-2 text-lg font-bold text-gray-700 dark:text-gray-300">Create Your Account</h3>
                                    <p class="text-lg text-gray-500 dark:text-gray-400">Sign up quickly and easily to access our full range of features.</p>
                                </div>
                                </li>
                                <li class="flex pb-10 mb-8 border-b border-gray-200 dark:border-gray-700">
                                <div class="mr-8">
                                    <span class="flex justify-center items-center w-14 h-14 bg-blue-200/50 dark:bg-blue-600/30 text-lg font-bold rounded-full text-blue-600 dark:text-blue-300">2</span>
                                </div>
                                <div class="">
                                    <h3 class="mb-2 text-lg font-bold text-gray-700 dark:text-gray-300">Personalize Your Experience</h3>
                                    <p class="text-lg text-gray-500 dark:text-gray-400">Tailor tools and settings to fit your needs and preferences.</p>
                                </div>
                                </li>
                                <li class="flex pb-10 border-b border-gray-200 dark:border-gray-700">
                                <div class="mr-8">
                                    <span class="flex justify-center items-center w-14 h-14 bg-blue-200/50 dark:bg-blue-600/30 text-lg font-bold rounded-full text-blue-600 dark:text-blue-300">3</span>
                                </div>
                                <div class="">
                                    <h3 class="mb-2 text-lg font-bold text-gray-700 dark:text-gray-300">Collaborate with Your Team</h3>
                                    <p class="text-lg text-gray-500 dark:text-gray-400">Seamlessly work together, sharing insights and tools for better productivity.</p>
                                </div>
                                </li>
                            </ul>
                        </div>

                   
                    
                    <div class="space-y-6">
                        <div class="mb-6">
                            <h3 class="font-medium mb-2">Demander un congé</h3>
                            <p>1. Cliquez sur "Mes congés" dans le menu principal</p>
                            <p>2. Cliquez sur le bouton "Nouveau congé"</p>
                            <p>3. Remplissez le formulaire avec les dates et le type de congé</p>
                            <p>4. Ajoutez un justificatif si nécessaire</p>
                            <p>5. Soumettez votre demande</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-medium mb-2">Suivi de vos demandes</h3>
                            <p>- Consultez l'état de vos demandes dans la section "Mes congés"</p>
                            <p>- Les statuts possibles sont : En attente, Approuvé, Refusé</p>
                            <p>- Vous recevrez des notifications par email pour tout changement de statut</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-medium mb-2">Gestion des départements</h3>
                            <p>- Gestion des départements et des employés associés</p>
                            <p>- Cliquez sur "Gestion des départements" dans le menu principal</p>
                            <p>- Consultez la liste des départements et les employés associés</p>
                            <p>- Ajoutez, modifiez ou supprimez des départements et des employés</p>
                        </div>

                        <div class="mb-6">  
                            <h3 class="font-medium mb-2">Gestion des utilisateurs</h3>
                            <p>- Gestion des utilisateurs et des permissions</p>
                            <p>- Cliquez sur "Gestion des utilisateurs" dans le menu principal</p>
                            <p>- Consultez la liste des utilisateurs et leurs permissions</p>
                            <p>- Ajoutez, modifiez ou supprimez des utilisateurs et des permissions</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-medium mb-2">Besoin d'aide supplémentaire ?</h3>
                            <p>Contactez le service RH :</p>
                            <p>Email : rh@example.com</p>
                            <p>Téléphone : +XX XX XX XX XX</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>