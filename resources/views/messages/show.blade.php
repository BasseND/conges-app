<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Messagerie') }}
    </h2>
</x-slot>

@section('title', 'Conversation avec ' . $user->first_name . ' ' . $user->last_name)


<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de la conversation -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('messages.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux conversations
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                </div>
                <div class="w-32"></div> <!-- Spacer pour centrer le titre -->
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6">
            @if($messages->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Aucun message</h3>
                    <p class="text-gray-600 dark:text-gray-400">Commencez la conversation en envoyant le premier message.</p>
                </div>
            @else
                <div class="max-h-96 overflow-y-auto p-6 space-y-6">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                <!-- Message bubble -->
                                <div class="{{ $message->sender_id === auth()->id() 
                                    ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white' 
                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }} 
                                    rounded-lg px-4 py-3 shadow-sm">
                                    
                                    @if($loop->first || $messages[$loop->index - 1]->subject !== $message->subject)
                                        <div class="text-xs font-semibold mb-2 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-gray-600 dark:text-gray-400' }}">
                                            {{ $message->subject }}
                                        </div>
                                    @endif
                                    
                                    <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message->content }}</p>
                                </div>
                                
                                <!-- Métadonnées du message -->
                                <div class="flex items-center mt-1 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $message->sender->first_name }} {{ $message->sender->last_name }} • 
                                        {{ $message->created_at->format('d/m/Y à H:i') }}
                                        @if($message->sender_id === auth()->id() && $message->is_read)
                                            • <span class="text-green-500">Lu</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Formulaire de réponse -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répondre</h3>
            
            @if($messages->isNotEmpty())
                <form action="{{ route('messages.reply', $messages->first()) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Votre message
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="4" 
                                  class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                  placeholder="Tapez votre réponse ici..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Envoyer
                        </button>
                    </div>
                </form>
            @else
                <!-- Formulaire pour nouveau message -->
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                    
                    <div class="mb-4">
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
                    
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="4" 
                                  class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" 
                                  placeholder="Tapez votre message ici..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Envoyer
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-scroll vers le bas des messages
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('.max-h-96.overflow-y-auto');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>
@endpush
</x-app-layout>