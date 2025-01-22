<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le département') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.departments.update', $department) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $department->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code', $department->code)" required />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" 
                                class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $department->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="head_id" :value="__('Chef de département')" />
                            <select id="head_id" name="head_id" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner un chef de département</option>
                                @foreach($departmentHeads as $head)
                                    <option value="{{ $head->id }}" {{ (old('head_id', optional($department->head)->id) == $head->id) ? 'selected' : '' }}>
                                        {{ $head->name }} ({{ $head->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">
                                Seuls les utilisateurs avec le rôle "Chef de département" qui ne sont pas déjà assignés à un autre département sont listés ici.
                            </p>
                            <x-input-error :messages="$errors->get('head_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.departments.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
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
