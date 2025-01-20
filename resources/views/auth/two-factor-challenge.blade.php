<x-guest-layout>
    <div x-data="{ recovery: false }">
        <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
            Veuillez confirmer l'accès à votre compte en saisissant le code d'authentification fourni par votre application d'authentification.
        </div>

        <div class="mb-4 text-sm text-gray-600" x-show="recovery">
            Veuillez confirmer l'accès à votre compte en saisissant l'un de vos codes de récupération d'urgence.
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="mt-4" x-show="! recovery">
                <x-input-label for="code" value="Code" />
                <x-text-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="mt-4" x-show="recovery">
                <x-input-label for="recovery_code" value="Code de récupération" />
                <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() })
                        ">
                    Utiliser un code de récupération
                </button>

                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() })
                        ">
                    Utiliser un code d'authentification
                </button>

                <x-primary-button class="ml-4">
                    Se connecter
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
