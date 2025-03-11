<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'dark': $store.darkMode.on }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <!-- Style pour Alpine.js x-cloak -->
        <style>
            [x-cloak] { display: none !important; }
        </style>

        <!-- CSS de Flatpickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

        <!-- Script Flatpickr -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
         <!-- Script de langue francaise -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/sidebar.css', 'resources/js/app.js'])
        
        <!-- Dark Mode Script -->
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('darkMode', {
                    on: localStorage.getItem('darkMode') === 'true',
                    toggle() {
                        this.on = !this.on;
                        localStorage.setItem('darkMode', this.on);
                        this.updateDocumentClass();
                    },
                    updateDocumentClass() {
                        if (this.on) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    },
                    init() {
                        this.updateDocumentClass();
                    }
                });

                Alpine.store('sidebar', {
                    open: localStorage.getItem('sidebarOpen') === 'true',
                    toggle() {
                        this.open = !this.open;
                        localStorage.setItem('sidebarOpen', this.open);
                    }
                });
            });
        </script>

        <!-- Styles pour le dark mode -->
        <style>
            /* Transition douce pour le changement de mode */
            html.dark { color-scheme: dark; }
            .dark body {
                background-color: #1a1a1a;
                color: #ffffff;
            }
            * {
                transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            }
            
            /* Styles pour le contenu principal avec transition */
            .main-content {
                transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
            }
            
            /* Styles pour les erreurs de validation */
            .alert-error {
                background-color: #fee2e2;
                border-color: #f87171;
                color: #b91c1c;
                border-radius: 0.375rem;
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .dark .alert-error {
                background-color: #7f1d1d;
                border-color: #ef4444;
                color: #fca5a5;
            }
            
            .alert-error ul {
                list-style-type: disc;
                padding-left: 1.5rem;
                margin-top: 0.5rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" x-data x-init="$store.darkMode.init()">
        <div class="min-h-screen flex flex-col">
            <!-- Top Navigation -->
            <header class="w-full z-30">
                @include('layouts.navigation')
            </header>

            <div class="flex flex-1 overflow-hidden">
                <!-- Sidebar Navigation -->
                @auth
                    @include('layouts.sidebar')
                @endauth

                <!-- Main Content Container -->
                <div class="main-content flex-1 flex flex-col overflow-x-hidden" 
                     :class="{'lg:ml-64': $store.sidebar.open, 'lg:ml-0': !$store.sidebar.open}">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <div class="bg-white dark:bg-gray-800 shadow">
                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endif

                    <!-- Affichage des erreurs de validation en haut de la page -->
                    @if ($errors->any())
                        <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                            <div class="alert-error">
                                <div class="font-medium">{{ __('Veuillez corriger les erreurs suivantes:') }}</div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <main role="main" class="flex-1 py-4 px-4 sm:px-6 lg:px-8">
                        <div class="max-w-7xl mx-auto">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    </body>
</html>
