<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
            {{ __('Nouveau département') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.departments.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nom du département')" />
                            <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="code" :value="__('Code du département')" />
                            <x-text-input id="code" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600" type="text" name="code" :value="old('code')" required />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Le code doit être unique et sera utilisé comme identifiant.</p>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" 
                                class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="head_id" :value="__('Chef de département')" />
                            <select id="head_id" name="head_id" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner un chef de département</option>
                                @foreach($departmentHeads as $head)
                                    <option value="{{ $head->id }}" {{ old('head_id') == $head->id ? 'selected' : '' }}>
                                        {{ $head->name }} ({{ $head->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">
                                Seuls les utilisateurs avec le rôle "Chef de département" qui ne sont pas déjà assignés à un département sont listés ici.
                            </p>
                            <x-input-error :messages="$errors->get('head_id')" class="mt-2" />
                        </div>

                        {{-- <div>
                            <x-input-label for="manager_id" :value="__('Manager')" />
                            <select id="manager_id" name="manager_id" class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionner un manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }} ({{ $manager->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
                        </div> --}}

                        <div class="flex items-center justify-end gap-2 mt-4">
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Créer le département') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
