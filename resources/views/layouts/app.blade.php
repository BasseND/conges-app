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
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
