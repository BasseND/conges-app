<!-- Variables pour les routes -->
<script>
    window.leaveBalanceRoutes = {
        store: '{{ route("admin.company.leave-balances.store") }}',
        update: '{{ route("admin.company.leave-balances.update", "") }}'
    };
    
    // Fonction de soumission du formulaire
    window.submitLeaveBalanceForm = async function(modalContext) {
        modalContext.submitting = true;
        
        const form = document.getElementById('leaveBalanceForm');
        const formData = new FormData(form);
        
        const url = modalContext.isEdit ? 
            window.leaveBalanceRoutes.update + '/' + modalContext.leaveBalanceId : 
            window.leaveBalanceRoutes.store;
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                if (typeof window.showNotification === 'function') {
                    window.showNotification(data.message, 'success');
                }
                modalContext.open = false;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (data.errors) {
                    let errorMessage = 'Erreurs de validation:\n';
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorMessage += '- ' + error + '\n';
                        });
                    });
                    alert(errorMessage);
                } else {
                    alert(data.message || 'Une erreur est survenue');
                }
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur de connexion. Veuillez réessayer.');
        } finally {
            modalContext.submitting = false;
        }
    };
</script>

<!-- Modal moderne pour ajouter/modifier un solde de congés -->
<div x-data="{ 
        open: false, 
        leaveBalanceId: null, 
        isEdit: false,
        submitting: false,
        init() {
            console.log('Modal leave balance initialisé');
            window.addEventListener('open-leave-balance-modal', (event) => {
                console.log('Événement open-leave-balance-modal reçu', event.detail);
                this.leaveBalanceId = event.detail?.leaveBalanceId;
                this.isEdit = !!event.detail?.leaveBalanceId;
                this.open = true;
                
                if (this.isEdit && event.detail?.data) {
                    this.$nextTick(() => {
                        const data = event.detail.data;
                        document.getElementById('description').value = data.description || '';
                        document.getElementById('annual_leave_days').value = data.annual_leave_days || '';

                        document.getElementById('maternity_leave_days').value = data.maternity_leave_days || '';
                        document.getElementById('paternity_leave_days').value = data.paternity_leave_days || '';
                        document.getElementById('special_leave_days').value = data.special_leave_days || '';
                        document.getElementById('is_default').checked = data.is_default || false;
                    });
                }
            });
        }
    }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
            @click.self="open = false">
        <!-- Fond sombre avec effet de flou -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        </div>

        <!-- Contenu du modal moderne -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border-0">
            <!-- En-tête du modal -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white" x-text="isEdit ? 'Modifier le solde de congés' : 'Ajouter un solde de congés'"></h3>
                    </div>
                    <button type="button" @click="open = false" 
                            class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="leaveBalanceForm" @submit.prevent="window.submitLeaveBalanceForm($data)" class="p-6">
                @csrf
                <input type="hidden" name="_method" x-bind:value="isEdit ? 'PUT' : 'POST'">
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="space-y-6">
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Description
                        </label>
                        <input type="text" id="description" name="description" required 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                placeholder="Entrez une description pour ce profil de congés">
                    </div>
                    
                    <!-- Grille des types de congés -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Congés annuels -->
                        <div>
                            <label for="annual_leave_days" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Congés annuels (jours)
                            </label>
                            <input type="number" id="annual_leave_days" name="annual_leave_days" min="0" max="365" required 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                    placeholder="25">
                        </div>
                        

                        
                        <!-- Congés maternité -->
                        <div>
                            <label for="maternity_leave_days" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <svg class="w-4 h-4 text-pink-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                                Congés maternité (jours)
                            </label>
                            <input type="number" id="maternity_leave_days" name="maternity_leave_days" min="0" max="365" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                    placeholder="112">
                        </div>
                        
                        <!-- Congés paternité -->
                        <div>
                            <label for="paternity_leave_days" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Congés paternité (jours)
                            </label>
                            <input type="number" id="paternity_leave_days" name="paternity_leave_days" min="0" max="365" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                    placeholder="25">
                        </div>
                        
                        <!-- Congés spéciaux -->
                        <div class="md:col-span-2">
                            <label for="special_leave_days" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                </svg>
                                Congés spéciaux (jours)
                            </label>
                            <input type="number" id="special_leave_days" name="special_leave_days" min="0" max="365" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                    placeholder="5">
                        </div>
                    </div>
                    
                    <!-- Option par défaut -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-300 dark:border-gray-600 p-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_default" name="is_default" value="1" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_default" class="ml-3 flex items-center cursor-pointer flex-1">
                                <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-sm text-gray-900 dark:text-white font-medium">Définir comme solde par défaut</span>
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 ml-7">
                            Ce profil sera automatiquement assigné aux nouveaux utilisateurs
                        </p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" @click="open = false" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting"
                            class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg x-show="!submitting" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                        </svg>
                        <svg x-show="submitting" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="submitting ? 'En cours...' : (isEdit ? 'Mettre à jour' : 'Ajouter')"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>