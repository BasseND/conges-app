<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
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
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" x-data x-init="$store.darkMode.init()">
        <div class="min-h-screen">
            <header role="banner">
                 @include('layouts.navigation')
            </header>

            <!-- Page Heading -->
            @if (isset($header))
                <div class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main role="main">
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    </body>
</html>
