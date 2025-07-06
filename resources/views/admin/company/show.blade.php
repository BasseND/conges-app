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
                                                @if($company->website_url)
                                                    <a href="{{ $company->website_url }}" target="_blank" class="text-base font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">{{ $company->website_url }}</a>
                                                @else
                                                    <span class="text-base font-medium text-gray-400 dark:text-gray-500">Non renseigné</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bloc congés -->
                            <div class="bg-gray-50 dark:bg-dark-card-two rounded-xl p-7 border border-gray-100 mt-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        <i class="bx bx-calendar mr-2"></i>Soldes de congés définis
                                    </h3>
                                    <button type="button" onclick="openLeaveBalanceModal()" class="inline-flex items-center btn btn-primary">
                                        <i class="bx bx-plus mr-1"></i> Ajouter un solde
                                    </button>
                                </div>
                                
                                @if($leaveBalances->count() > 0)
                                    <div class="grid gap-4">
                                        @foreach($leaveBalances as $balance)
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $balance->description }}</h4>
                                                            @if($balance->is_default)
                                                                <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Par défaut</span>
                                                            @endif
                                                        </div>
                                                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                                                            <!-- <div>
                                                                <span class="text-gray-500 dark:text-gray-400">Congés annuels:</span>
                                                                <div class="font-medium text-gray-900 dark:text-white">{{ $balance->annual_leave_days }} jours</div>
                                                            </div> -->
                                                           <!-- Conges annuels  -->
                                                            <div class="bg-white dark:bg-dark-card p-2 rounded-lg shadow-sm">
                                                                <div class="flex items-center">
                                                                    <div class="bg-blue-100 text-blue-600 dark:bg-blue-900/20 p-2 rounded-lg mr-3">
                                                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-base font-medium text-bgray-600 dark:text-bgray-50">Congés annuels</p>
                                                                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $balance->annual_leave_days }} jours</p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <span class="text-gray-500 dark:text-gray-400">Congés maladie:</span>
                                                                <div class="font-medium text-gray-900 dark:text-white">{{ $balance->sick_leave_days }} jours</div>
                                                            </div>
                                                            @if($balance->maternity_leave_days)
                                                                <div>
                                                                    <span class="text-gray-500 dark:text-gray-400">Congés maternité:</span>
                                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $balance->maternity_leave_days }} jours</div>
                                                                </div>
                                                            @endif
                                                            @if($balance->paternity_leave_days)
                                                                <div>
                                                                    <span class="text-gray-500 dark:text-gray-400">Congés paternité:</span>
                                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $balance->paternity_leave_days }} jours</div>
                                                                </div>
                                                            @endif
                                                            @if($balance->special_leave_days)
                                                                <div>
                                                                    <span class="text-gray-500 dark:text-gray-400">Congés spéciaux:</span>
                                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $balance->special_leave_days }} jours</div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                            <strong>Total: {{ $balance->total_leave_days }} jours</strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex space-x-2 ml-4">
                                                        <button type="button" onclick="editLeaveBalance({{ $balance->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                            <i class="bx bx-edit text-lg"></i>
                                                        </button>
                                                        <button type="button" onclick="deleteLeaveBalance({{ $balance->id }})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                            <i class="bx bx-trash text-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="bx bx-calendar-x text-gray-400 text-4xl mb-2"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Aucun solde de congés défini</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Cliquez sur "Ajouter un solde" pour commencer</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Modal pour définir les congés  -->
                            <div id="leaveBalanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                                    <div class="mt-3">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Ajouter un solde de congés</h3>
                                            <button type="button" onclick="closeLeaveBalanceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                <i class="bx bx-x text-2xl"></i>
                                            </button>
                                        </div>
                                        
                                        <form id="leaveBalanceForm">
                                            @csrf
                                            <input type="hidden" id="leaveBalanceId" name="leave_balance_id">
                                            <input type="hidden" id="formMethod" name="_method">
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="md:col-span-2">
                                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                                    <input type="text" id="description" name="description" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="annual_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés annuels (jours)</label>
                                                    <input type="number" id="annual_leave_days" name="annual_leave_days" min="0" max="365" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="sick_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés maladie (jours)</label>
                                                    <input type="number" id="sick_leave_days" name="sick_leave_days" min="0" max="365" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="maternity_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés maternité (jours)</label>
                                                    <input type="number" id="maternity_leave_days" name="maternity_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="paternity_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés paternité (jours)</label>
                                                    <input type="number" id="paternity_leave_days" name="paternity_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="special_leave_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Congés spéciaux (jours)</label>
                                                    <input type="number" id="special_leave_days" name="special_leave_days" min="0" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                </div>
                                                
                                                <div class="md:col-span-2">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" id="is_default" name="is_default" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Définir comme solde par défaut</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-end space-x-3">
                                                <button type="button" onclick="closeLeaveBalanceModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-700">
                                                    Annuler
                                                </button>
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <span id="submitButtonText">Ajouter</span>
                                                </button>
                                            </div>
                                        </form>
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

    <script>
        let leaveBalances = @json($leaveBalances);
        let isEditing = false;
        let editingId = null;

        function openLeaveBalanceModal() {
            isEditing = false;
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Ajouter un solde de congés';
            document.getElementById('submitButtonText').textContent = 'Ajouter';
            document.getElementById('leaveBalanceForm').reset();
            document.getElementById('leaveBalanceId').value = '';
            document.getElementById('formMethod').value = '';
            document.getElementById('leaveBalanceModal').classList.remove('hidden');
        }

        function closeLeaveBalanceModal() {
            document.getElementById('leaveBalanceModal').classList.add('hidden');
        }

        function editLeaveBalance(id) {
            const balance = leaveBalances.find(b => b.id === id);
            if (!balance) return;

            isEditing = true;
            editingId = id;
            document.getElementById('modalTitle').textContent = 'Modifier le solde de congés';
            document.getElementById('submitButtonText').textContent = 'Modifier';
            
            // Remplir le formulaire
            document.getElementById('leaveBalanceId').value = balance.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('description').value = balance.description;
            document.getElementById('annual_leave_days').value = balance.annual_leave_days;
            document.getElementById('sick_leave_days').value = balance.sick_leave_days;
            document.getElementById('maternity_leave_days').value = balance.maternity_leave_days || '';
            document.getElementById('paternity_leave_days').value = balance.paternity_leave_days || '';
            document.getElementById('special_leave_days').value = balance.special_leave_days || '';
            document.getElementById('is_default').checked = balance.is_default;
            
            document.getElementById('leaveBalanceModal').classList.remove('hidden');
        }

        function deleteLeaveBalance(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce solde de congés ?')) {
                return;
            }

            fetch(`{{ route('admin.company.leave-balances.destroy', '') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.error || 'Erreur lors de la suppression', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erreur lors de la suppression', 'error');
            });
        }

        document.getElementById('leaveBalanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Convertir les valeurs numériques
            ['annual_leave_days', 'sick_leave_days', 'maternity_leave_days', 'paternity_leave_days', 'special_leave_days'].forEach(field => {
                if (data[field] === '') {
                    delete data[field];
                } else {
                    data[field] = parseInt(data[field]) || 0;
                }
            });
            
            // Gérer la checkbox
            data.is_default = document.getElementById('is_default').checked;
            
            let url, method;
            if (isEditing) {
                url = `{{ route('admin.company.leave-balances.update', '') }}/${editingId}`;
                method = 'PUT';
            } else {
                url = '{{ route('admin.company.leave-balances.store') }}';
                method = 'POST';
            }
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeLeaveBalanceModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else if (data.errors) {
                    // Afficher les erreurs de validation
                    let errorMessage = 'Erreurs de validation:\n';
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });
                    showNotification(errorMessage, 'error');
                } else {
                    showNotification(data.error || 'Erreur lors de la sauvegarde', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erreur lors de la sauvegarde', 'error');
            });
        });

        function showNotification(message, type = 'info') {
            // Créer la notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' :
                'bg-blue-100 border border-blue-400 text-blue-700'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm font-medium">${message.replace(/\n/g, '<br>')}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Supprimer automatiquement après 5 secondes
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('leaveBalanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLeaveBalanceModal();
            }
        });
    </script>
</x-app-layout>
