<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la demande de congé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('leaves.update', $leave) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="type" :value="__('Type de congé')" />
                            <select id="type" name="type" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(App\Models\Leave::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $leave->type) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="start_date" :value="__('Date de début')" />
                            <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date', $leave->start_date)" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="end_date" :value="__('Date de fin')" />
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $leave->end_date)" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="reason" :value="__('Motif')" />
                            <textarea id="reason" name="reason" rows="3" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason', $leave->reason) }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="attachments" :value="__('Pièces jointes')" />
                            <input type="file" id="attachments" name="attachments[]" multiple 
                                class="block w-full text-sm text-gray-900 dark:text-gray-100
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-600 file:text-white
                                hover:file:bg-indigo-700
                                file:cursor-pointer file:shadow-sm" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Formats acceptés : PDF, JPG, JPEG, PNG. Taille maximale : 10 Mo.
                            </p>
                            <x-input-error :messages="$errors->get('attachments.*')" class="mt-2" />

                            @if($leave->attachments->count() > 0)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Pièces jointes actuelles :</h4>
                                    <ul class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($leave->attachments as $attachment)
                                            <li class="py-2 flex items-center justify-between">
                                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $attachment->original_filename }}</span>
                                                <a href="{{ route('leaves.download-attachment', ['leave' => $leave->id, 'attachment' => $attachment->id]) }}" 
                                                   class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    Télécharger
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('leaves.show', $leave) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
