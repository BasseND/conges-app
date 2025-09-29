@section('title', 'Conversation avec ' . $user->first_name . ' ' . $user->last_name)
<x-app-layout>


    <div class="w-full">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">  
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"> {{ $user->first_name }} {{ $user->last_name }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('messages.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Retour aux conversations
                            </a>
                        </div>

                       
                    </div>
                </div>
            </div>


            <div class="">
                <!-- Messages -->
                <div class="bg-white dark:bg-gray-800 border-b border-gray-300 overflow-hidden">
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
                                            ? 'bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 border border-indigo-200/50 dark:border-indigo-700/50' 
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }} 
                                            rounded-lg px-4 py-3 shadow-sm">
                                            
                                            @if($loop->first || $messages[$loop->index - 1]->subject !== $message->subject)
                                                <div class="font-semibold text-indigo-900 dark:text-indigo-100 mb-2 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-gray-600 dark:text-gray-400' }}">
                                                    {{ $message->subject }}
                                                </div>
                                            @endif
                                            
                                            <div class="text-sm leading-relaxed prose prose-sm max-w-none dark:prose-invert">{!! $message->content !!}</div>
                                            
                                            <!-- Pièces jointes -->
                                            @if($message->attachments->count() > 0)
                                                <div class="mt-3 pt-3 border-t {{ $message->sender_id === auth()->id() ? 'border-blue-400' : 'border-gray-300 dark:border-gray-600' }}">
                                                    <div class="text-xs font-semibold mb-2 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-gray-600 dark:text-gray-400' }}">
                                                        Pièces jointes ({{ $message->attachments->count() }})
                                                    </div>
                                                    <div class="space-y-2">
                                                        @foreach($message->attachments as $attachment)
                                                            <a href="{{ route('messages.download-attachment', $attachment) }}" 
                                                               class="flex items-center space-x-2 p-2 rounded {{ $message->sender_id === auth()->id() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500' }} transition-colors duration-200">
                                                                <!-- Icône selon le type de fichier -->
                                                                @if($attachment->isImage())
                                                                    <svg class="w-4 h-4 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                @elseif($attachment->isPdf())
                                                                    <svg class="w-4 h-4 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                @elseif($attachment->isWordDocument())
                                                                    <svg class="w-4 h-4 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                @elseif($attachment->isExcelDocument())
                                                                    <svg class="w-4 h-4 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                @endif
                                                                
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-xs font-medium {{ $message->sender_id === auth()->id() ? 'text-blue-100' : 'text-gray-900 dark:text-gray-100' }} truncate">
                                                                        {{ $attachment->original_name }}
                                                                    </p>
                                                                    <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-blue-200' : 'text-gray-500 dark:text-gray-400' }}">
                                                                        {{ $attachment->getFormattedFileSize() }}
                                                                    </p>
                                                                </div>
                                                                
                                                                <svg class="w-3 h-3 {{ $message->sender_id === auth()->id() ? 'text-blue-200' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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
                <div class="bg-white dark:bg-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répondre</h3>
                    
                    @if($messages->isNotEmpty())
                        <form action="{{ route('messages.reply', $messages->first()) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Votre message
                                </label>
                                <!-- Éditeur WYSIWYG pour réponse -->
                                <div id="reply-editor" class="bg-white dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600" style="min-height: 150px;">
                                    {!! old('content') !!}
                                </div>
                                <!-- Champ caché pour le contenu -->
                                <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
        
                            <!-- Section pour les pièces jointes -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pièces jointes (optionnel)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                    <input type="file" 
                                           id="reply-attachments" 
                                           name="attachments[]" 
                                           multiple 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.svg"
                                           class="hidden"
                                           onchange="handleReplyFileSelect(event)">
                                    <label for="reply-attachments" class="cursor-pointer">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-2">
                                            <span class="text-blue-600 hover:text-blue-500 font-medium">Cliquez pour sélectionner</span>
                                            <span class="text-gray-500"> ou glissez-déposez vos fichiers ici</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">PDF, Word, Excel, Images (max 10 Mo par fichier, 5 fichiers max)</p>
                                    </label>
                                </div>
                                
                                <!-- Affichage des fichiers sélectionnés -->
                                <div id="reply-selected-files" class="mt-3 space-y-2"></div>
                                
                                @error('attachments')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('attachments.*')
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
                        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
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
                                <!-- Éditeur WYSIWYG pour nouveau message -->
                                <div id="new-message-editor" class="bg-white dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600" style="min-height: 150px;">
                                    {!! old('content') !!}
                                </div>
                                <!-- Champ caché pour le contenu -->
                                <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
        
                            <!-- Section pour les pièces jointes -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pièces jointes (optionnel)
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                    <input type="file" 
                                           id="new-message-attachments" 
                                           name="attachments[]" 
                                           multiple 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.svg"
                                           class="hidden"
                                           onchange="handleNewMessageFileSelect(event)">
                                    <label for="new-message-attachments" class="cursor-pointer">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-2">
                                            <span class="text-blue-600 hover:text-blue-500 font-medium">Cliquez pour sélectionner</span>
                                            <span class="text-gray-500"> ou glissez-déposez vos fichiers ici</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">PDF, Word, Excel, Images (max 10 Mo par fichier, 5 fichiers max)</p>
                                    </label>
                                </div>
                                
                                <!-- Affichage des fichiers sélectionnés -->
                                <div id="new-message-selected-files" class="mt-3 space-y-2"></div>
                                
                                @error('attachments')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('attachments.*')
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
    </div>
    

 







<style>
.ql-snow .ql-editor {
    min-height: 200px;
}
</style>

@push('scripts')
<script>
// Auto-scroll vers le bas des messages
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('.max-h-96.overflow-y-auto');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Gestion des fichiers pour le formulaire de réponse
function handleReplyFileSelect(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('reply-selected-files');
    container.innerHTML = '';
    
    files.forEach((file, index) => {
        const fileDiv = document.createElement('div');
        fileDiv.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border';
        
        const fileInfo = document.createElement('div');
        fileInfo.className = 'flex items-center space-x-3';
        
        const icon = getFileIcon(file.type);
        const fileName = document.createElement('span');
        fileName.className = 'text-sm font-medium text-gray-900 dark:text-white';
        fileName.textContent = file.name;
        
        const fileSize = document.createElement('span');
        fileSize.className = 'text-xs text-gray-500';
        fileSize.textContent = formatFileSize(file.size);
        
        fileInfo.appendChild(icon);
        fileInfo.appendChild(fileName);
        fileInfo.appendChild(fileSize);
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'text-red-500 hover:text-red-700';
        removeBtn.innerHTML = '×';
        removeBtn.onclick = () => removeReplyFile(index);
        
        fileDiv.appendChild(fileInfo);
        fileDiv.appendChild(removeBtn);
        container.appendChild(fileDiv);
    });
}

// Gestion des fichiers pour le formulaire de nouveau message
function handleNewMessageFileSelect(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('new-message-selected-files');
    container.innerHTML = '';
    
    files.forEach((file, index) => {
        const fileDiv = document.createElement('div');
        fileDiv.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border';
        
        const fileInfo = document.createElement('div');
        fileInfo.className = 'flex items-center space-x-3';
        
        const icon = getFileIcon(file.type);
        const fileName = document.createElement('span');
        fileName.className = 'text-sm font-medium text-gray-900 dark:text-white';
        fileName.textContent = file.name;
        
        const fileSize = document.createElement('span');
        fileSize.className = 'text-xs text-gray-500';
        fileSize.textContent = formatFileSize(file.size);
        
        fileInfo.appendChild(icon);
        fileInfo.appendChild(fileName);
        fileInfo.appendChild(fileSize);
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'text-red-500 hover:text-red-700';
        removeBtn.innerHTML = '×';
        removeBtn.onclick = () => removeNewMessageFile(index);
        
        fileDiv.appendChild(fileInfo);
        fileDiv.appendChild(removeBtn);
        container.appendChild(fileDiv);
    });
}

// Supprimer un fichier du formulaire de réponse
function removeReplyFile(index) {
    const input = document.getElementById('reply-attachments');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    handleReplyFileSelect({ target: input });
}

// Supprimer un fichier du formulaire de nouveau message
function removeNewMessageFile(index) {
    const input = document.getElementById('new-message-attachments');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    handleNewMessageFileSelect({ target: input });
}

// Obtenir l'icône selon le type de fichier
function getFileIcon(mimeType) {
    const icon = document.createElement('div');
    icon.className = 'w-8 h-8 flex items-center justify-center rounded text-white text-xs font-bold';
    
    if (mimeType.startsWith('image/')) {
        icon.className += ' bg-green-500';
        icon.textContent = 'IMG';
    } else if (mimeType === 'application/pdf') {
        icon.className += ' bg-red-500';
        icon.textContent = 'PDF';
    } else if (mimeType.includes('word') || mimeType.includes('document')) {
        icon.className += ' bg-blue-500';
        icon.textContent = 'DOC';
    } else if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) {
        icon.className += ' bg-green-600';
        icon.textContent = 'XLS';
    } else {
        icon.className += ' bg-gray-500';
        icon.textContent = 'FILE';
    }
    
    return icon;
}

// Formater la taille du fichier
function formatFileSize(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Initialisation des éditeurs Quill
let replyQuill, newMessageQuill;
document.addEventListener('DOMContentLoaded', function() {
    // Configuration commune pour les éditeurs
    const quillConfig = {
        theme: 'snow',
        placeholder: 'Tapez votre message ici...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    };

    // Initialiser l'éditeur pour les réponses
    if (document.getElementById('reply-editor')) {
        replyQuill = new Quill('#reply-editor', quillConfig);
        
        // Synchroniser avec le champ caché
        replyQuill.on('text-change', function() {
            const replyForm = document.querySelector('form[action*="reply"]');
            if (replyForm) {
                const contentField = replyForm.querySelector('#content');
                if (contentField) {
                    contentField.value = replyQuill.root.innerHTML;
                }
            }
        });

        // Gérer la soumission du formulaire de réponse
        const replyForm = document.querySelector('form[action*="reply"]');
        if (replyForm) {
            replyForm.addEventListener('submit', function() {
                const contentField = replyForm.querySelector('#content');
                if (contentField) {
                    contentField.value = replyQuill.root.innerHTML;
                }
            });
        }
    }

    // Initialiser l'éditeur pour les nouveaux messages
    if (document.getElementById('new-message-editor')) {
        newMessageQuill = new Quill('#new-message-editor', quillConfig);
        
        // Synchroniser avec le champ caché
        newMessageQuill.on('text-change', function() {
            const newMessageForm = document.querySelector('form[action*="store"]');
            if (newMessageForm) {
                const contentField = newMessageForm.querySelector('#content');
                if (contentField) {
                    contentField.value = newMessageQuill.root.innerHTML;
                }
            }
        });

        // Gérer la soumission du formulaire de nouveau message
        const newMessageForm = document.querySelector('form[action*="store"]');
        if (newMessageForm) {
            newMessageForm.addEventListener('submit', function() {
                const contentField = newMessageForm.querySelector('#content');
                if (contentField) {
                    contentField.value = newMessageQuill.root.innerHTML;
                }
            });
        }
    }
});
</script>
@endpush
</x-app-layout>