@props(['title' => 'Confirmation de suppression', 'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible et toutes les données associées seront définitivement supprimées.'])

<div id="deleteModal" class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-700">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">{{ $title }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $message }}
                </p>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <button onclick="hideDeleteModal()"
                        class="bg-gray-500 dark:bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 dark:bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-600">
                         Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDeleteModal(route) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = route;
        modal.classList.remove('hidden');
    }

    function hideDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>
