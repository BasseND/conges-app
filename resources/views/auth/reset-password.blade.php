@section('title', 'Réinitialiser le mot de passe')

<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('password.store') }}">
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
                            Reinitialiser votre mot de passe
                            </h2>
                        </header>
                    <div>

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <x-text-input 
                        id="email" 
                        class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                        placeholder="Votre email" 
                        type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-text-input id="password" 
                        class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base" 
                        placeholder="Votre mot de passe" 
                        type="password" 
                        name="password" 
                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-text-input id="password_confirmation" 
                        class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button 
                        type="submit"
                        class="py-3.5 flex items-center justify-center text-white font-bold bg-success-300 hover:bg-success-400 transition-all rounded-lg w-full"
                        >
                            {{ __('Reinitialiser le mot de passe') }}
                        </x-primary-button>
                    </div>

                    <p class="text-bgray-600 dark:text-white text-center text-sm mt-6">
                        {{ __('© 2025 RH Connect. Tous droits réservés.') }}
                    </p>
                    </div>

                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
