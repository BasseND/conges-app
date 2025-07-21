@section('title', 'Mot de passe oublié')
<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>

            <header>
               <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </header>
            <div class="max-w-[450px] m-auto pt-24 pb-16">
                <header class="text-center mb-8">
                    <h2
                    class="text-bgray-900 dark:text-white text-4xl font-semibold font-poppins mb-2"
                    >
                    Se connecter sur RH Connect
                    </h2>
                    <p class="font-urbanis text-base font-medium text-bgray-600 dark:text-bgray-50">
                    Gérez vos congés, vos notes de frais et vos bulletins de paie
                    </p>
                </header>
            
            
                <div>
                    <!-- Email Address -->
                    <div>
                        <x-text-input 
                        id="email" 
                        class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                        placeholder="Votre email"
                        type="email" 
                        name="email"
                        :value="old('email')" 
                        required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button 
                        class="py-3.5 flex items-center justify-center text-white font-bold bg-success-300 hover:bg-success-400 transition-all rounded-lg w-full"
                        type="submit">
                            {{ __('Envoyer le lien de réinitialisation') }}
                        </button>
                    </div>
                </div>
            
                <p class="text-bgray-600 dark:text-white text-center text-sm mt-6">
                    {{ __('© 2025 RH Connect. Tous droits réservés.') }}
                </p>
            </div>

        </div>




    </form>
</x-auth-layout>
