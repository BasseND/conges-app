<x-auth-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf


        <div class="pt-2">
          <header>
             <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
          </header>

          <div class="max-w-[460px] m-auto pt-24 pb-16">
            <header class="text-center mb-8">
              <h2
                class="text-bgray-900 dark:text-white text-4xl font-semibold font-poppins mb-2"
              >
                Créer un compte
              </h2>
              <p class="font-urbanis text-base font-medium text-bgray-600 dark:text-darkblack-300">
                Pour gérer vos congés, vos notes de frais et vos bulletins de paie
              </p>
            </header>
          
           
            <!-- Form -->
            <div>


             
               <!-- Name -->
        <div class="flex flex-col md:flex-row gap-4 justify-between mb-4">
            <div>
                <x-text-input 
                id="first_name" 
                class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                placeholder="Prénom"
                type="text" 
                name="first_name" 
                :value="old('first_name')" 
                
                required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div class="">
                <x-text-input 
                id="last_name" 
                class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                placeholder="Nom de famille"
                type="text" name="last_name" 
                :value="old('last_name')" 
                required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input 
            id="email" 
            class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
            placeholder="Email" 
            type="email" 
            name="email" 
            :value="old('email')" 
            required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-text-input 
            id="phone" 
            class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
            placeholder="Téléphone" 
            type="text" 
            name="phone" 
            :value="old('phone')" 
            required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
           <div class="mt-4 relative">
                <x-text-input 
                id="password" 
                class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                placeholder="Mot de passe" 
                type="password"
                name="password"
                required autocomplete="new-password" />
                <button class="absolute top-4 right-4 bottom-4">
                    <svg
                        width="22"
                        height="20"
                        viewBox="0 0 22 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        d="M2 1L20 19"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                        <path
                        d="M9.58445 8.58704C9.20917 8.96205 8.99823 9.47079 8.99805 10.0013C8.99786 10.5319 9.20844 11.0408 9.58345 11.416C9.95847 11.7913 10.4672 12.0023 10.9977 12.0024C11.5283 12.0026 12.0372 11.7921 12.4125 11.417"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                        <path
                        d="M8.363 3.36506C9.22042 3.11978 10.1082 2.9969 11 3.00006C15 3.00006 18.333 5.33306 21 10.0001C20.222 11.3611 19.388 12.5241 18.497 13.4881M16.357 15.3491C14.726 16.4491 12.942 17.0001 11 17.0001C7 17.0001 3.667 14.6671 1 10.0001C2.369 7.60506 3.913 5.82506 5.632 4.65906"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                    </svg>
                </button>

                
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
           <div class="mt-4 relative">
                <x-text-input 
                id="password_confirmation" 
                class="text-bgray-800 dark:text-white dark:bg-darkblack-500 dark:border-darkblack-400 text-base border border-bgray-300 h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                placeholder="Confirmer le mot de passe" 
                type="password"
                name="password_confirmation" 
                required autocomplete="new-password" />

                <button class="absolute top-4 right-4 bottom-4">
                    <svg
                        width="22"
                        height="20"
                        viewBox="0 0 22 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        d="M2 1L20 19"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                        <path
                        d="M9.58445 8.58704C9.20917 8.96205 8.99823 9.47079 8.99805 10.0013C8.99786 10.5319 9.20844 11.0408 9.58345 11.416C9.95847 11.7913 10.4672 12.0023 10.9977 12.0024C11.5283 12.0026 12.0372 11.7921 12.4125 11.417"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                        <path
                        d="M8.363 3.36506C9.22042 3.11978 10.1082 2.9969 11 3.00006C15 3.00006 18.333 5.33306 21 10.0001C20.222 11.3611 19.388 12.5241 18.497 13.4881M16.357 15.3491C14.726 16.4491 12.942 17.0001 11 17.0001C7 17.0001 3.667 14.6671 1 10.0001C2.369 7.60506 3.913 5.82506 5.632 4.65906"
                        stroke="#718096"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>




              

              <div class="flex justify-between mb-7">
                <div class="flex items-center gap-x-3">
                  <input
                    type="checkbox"
                    class="w-5 h-5 focus:ring-transparent rounded-md border border-bgray-300 focus:accent-success-300 text-success-300 dark:bg-transparent dark:border-darkblack-400"
                    name="remember"
                    id="remember"
                  />
                  <label for="remember" class="text-bgray-600 dark:text-bgray-50 text-base"
                    >En vous inscrivant, vous acceptez notre
                    <span class="text-bgray-900 dark:text-white">Politique de confidentialité,</span> et
                    <span class="text-bgray-900 dark:text-white"
                      >Politique de communication</span
                    >.</label
                  >
                </div>
              </div>
              <a
                href="{{ route('login') }}"
                class="py-3.5 flex items-center justify-center text-white font-bold bg-success-300 hover:bg-success-400 transition-all rounded-lg w-full"
              >
                S'inscrire
              </a>
            </div>
            <!-- Form Bottom -->
            <p class="text-center text-bgray-900 dark:text-bgray-50 text-base font-medium pt-7">
              Déjà inscrit?
              <a href="{{ route('login') }}" class="font-semibold underline">Se connecter</a>
            </p>
           
            <!-- Copyright -->
            <p class="text-bgray-600 dark:text-darkblack-300 text-center text-sm mt-6">
              &copy; 2025 RH Connect. Tous droits réservés.
            </p>
          </div>
        </div>

    </form>
</x-auth-layout>
