<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Authentification à deux facteurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(! auth()->user()->two_factor_secret)
                        {{-- Activer 2FA --}}
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                            @csrf
                            <div class="mt-4">
                                <x-primary-button type="submit">
                                    Activer l'authentification à deux facteurs
                                </x-primary-button>
                            </div>
                        </form>
                    @else
                        {{-- Désactiver 2FA --}}
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                            @csrf
                            @method('DELETE')
                            <div class="mt-4">
                                <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700">
                                    Désactiver l'authentification à deux facteurs
                                </x-primary-button>
                            </div>
                        </form>

                        @if(session('status') == 'two-factor-authentication-enabled')
                            {{-- Afficher le QR Code --}}
                            <div class="mt-4">
                                <p class="font-semibold mb-4">
                                    L'authentification à deux facteurs est maintenant activée. Scannez le code QR suivant en utilisant l'application d'authentification de votre téléphone.
                                </p>
                                <div class="mb-4">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                            </div>

                            {{-- Afficher les codes de récupération --}}
                            <div class="mt-4">
                                <p class="font-semibold mb-4">
                                    Stockez ces codes de récupération dans un gestionnaire de mots de passe sécurisé. Ils peuvent être utilisés pour récupérer l'accès à votre compte si votre appareil d'authentification à deux facteurs est perdu.
                                </p>

                                <div class="bg-gray-100 p-4 rounded-lg">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <div>{{ $code }}</div>
                                    @endforeach
                                </div>

                                <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}" class="mt-4">
                                    @csrf
                                    <x-primary-button type="submit">
                                        Régénérer les codes de récupération
                                    </x-primary-button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
