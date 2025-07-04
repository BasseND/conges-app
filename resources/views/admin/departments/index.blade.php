<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold pb-5 text-bgray-900 dark:text-white">
                {{ __('Gestion des départements') }}
            </h2>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary inline-flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            Nouveau département
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Chef de Département</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employés</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($departments as $department)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap ">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $department->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.departments.show', $department) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                            {{ $department->name }}
                                        </a>
                                        @if($department->description)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($department->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($department->head)
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $department->head->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $department->head->email }}</div>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $department->employees->count() }} employé(s)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.departments.edit', $department) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <button @click="$dispatch('delete-dialog', '{{ route('admin.departments.destroy', $department) }}')" 
                                                class="text-red-600 dark:text-red-500 hover:text-red-900">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        Aucun département trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modals.delete-dialog message="Êtes-vous sûr de vouloir supprimer ce département ? Cette action est irréversible et toutes les données associées seront définitivement supprimées." />

</x-app-layout>
