<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nouveau message') }}
        </h2>
    </x-slot>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <a href="{{ route('messages.index') }}" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux messages
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nouveau message</h1>
                    <div class="w-32"></div> <!-- Spacer pour centrer le titre -->
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        
                        <!-- Destinataire -->
                        <div class="mb-6">
                            <label for="recipient_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Destinataire
                            </label>
                            <select name="recipient_id" 
                                    id="recipient_id" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">@if(auth()->user()->isHR())Sélectionner un employé...@elseSélectionner un responsable RH...@endif</option>
                                @if(auth()->user()->isHR())
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                @else
                                    @foreach($hrUsers as $user)
                                        <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }} - RH ({{ $user->email }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('recipient_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Sujet -->
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sujet
                            </label>
                            <input type="text" 
                                id="subject" 
                                name="subject" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                placeholder="Sujet du message"
                                value="{{ old('subject') }}"
                                required>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Message -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message
                            </label>
                            <textarea id="content" 
                                    name="content" 
                                    rows="8" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                    placeholder="Tapez votre message ici..."
                                    required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Boutons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('messages.index') }}" 
                            class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Informations d'aide -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">Informations importantes</h3>
                        <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            @if(auth()->user()->isHR())
                                <p>• En tant que RH, vous pouvez envoyer des messages à tous les employés.</p>
                                <p>• Les employés ne verront que les messages qui leur sont destinés.</p>
                            @else
                                <p>• Vous ne pouvez envoyer des messages qu'aux membres des Ressources Humaines.</p>
                                <p>• Vos messages restent confidentiels et ne sont visibles que par vous et les RH.</p>
                            @endif
                            <p>• Tous les messages sont sécurisés et confidentiels.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
