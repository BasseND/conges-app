<x-app-layout>

<div class="container">
  

        <div class="flex flex-col">
            <div class="w-full">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h1 class="text-2xl font-bold text-bgray-900 dark:text-white">Formulaire de modification</h1>
                    </div>
                    <div class="p-6">
                    <form action="{{ route('admin.company.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom de la société <span class="text-red-500">*</span></label>
                                    <input type="text" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400  dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') border-red-500 @enderror" 
                                           id="name" name="name" value="{{ old('name', $company->name ?? '') }}" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Champ devise caché -->
                            <input type="hidden" id="currency" name="currency" value="{{ old('currency', $company->currency ?? '') }}">
                            @error('currency')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="website_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Site web</label>
                            <input type="url" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('website_url') border-red-500 @enderror" 
                                   id="website_url" name="website_url" value="{{ old('website_url', $company->website_url ?? '') }}" 
                                   placeholder="https://www.exemple.com">
                            @error('website_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adresse</label>
                            <input type="text" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('address') border-red-500 @enderror" 
                                   id="address" name="address" value="{{ old('address', $company->address ?? '') }}">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Code postal</label>
                                <input type="text" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('postal_code') border-red-500 @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code', $company->postal_code ?? '') }}">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ville</label>
                                <input type="text" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('city') border-red-500 @enderror" 
                                       id="city" name="city" value="{{ old('city', $company->city ?? '') }}">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pays</label>
                                <select id="country" name="country" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('country') border-red-500 @enderror">
                                    <option value="">Sélectionnez un pays</option>
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localisation</label>
                            <input type="text" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('location') border-red-500 @enderror" 
                                   id="location" name="location" value="{{ old('location', $company->location ?? '') }}" 
                                   placeholder="Coordonnées GPS, région, etc.">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email de contact</label>
                                <input type="email" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('contact_email') border-red-500 @enderror" 
                                       id="contact_email" name="contact_email" value="{{ old('contact_email', $company->contact_email ?? '') }}">
                                @error('contact_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Téléphone de contact</label>
                                <input type="tel" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-green-300 focus:border-green-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('contact_phone') border-red-500 @enderror" 
                                       id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $company->contact_phone ?? '') }}">
                                @error('contact_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo de la société</label>
                            @if($company && $company->logo)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($company->logo) }}" alt="Logo actuel" class="h-24 w-auto border border-gray-300 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Logo actuel</p>
                                </div>
                            @endif
                            <input type="file" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100
                                            dark:file:bg-indigo-900 dark:file:text-indigo-300 @error('logo') border-red-500 @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Formats acceptés : JPEG, PNG, JPG, GIF, SVG. Taille maximale : 2MB.</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('admin.company.show') }}" class="inline-flex items-center btn btn-secondary">
                                <i class="bx bx-arrow-back mr-1"></i> Retour
                            </a>
                            <button type="submit" class="inline-flex items-center btn btn-primary">
                                <i class="bx bx-save mr-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country');
    const currencyInput = document.getElementById('currency');
    
    // Charger les données des pays
    fetch('/data/countries.json')
        .then(response => response.json())
        .then(countries => {
            // Remplir le select avec les pays
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                option.dataset.currency = country.currency;
                option.dataset.currencySymbol = country.currencySymbol;
                countrySelect.appendChild(option);
            });
            
            // Restaurer la valeur sélectionnée si elle existe
            const currentCountry = '{{ old("country", $company->country ?? "") }}';
            if (currentCountry) {
                countrySelect.value = currentCountry;
                // Déclencher l'événement change pour mettre à jour la devise
                countrySelect.dispatchEvent(new Event('change'));
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des pays:', error);
        });
    
    // Gérer le changement de pays
    countrySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.currency) {
            currencyInput.value = selectedOption.dataset.currency;
        } else {
            currencyInput.value = '';
        }
    });
});
</script>