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
        @vite([
           'resources/assets/css/slick.css',
           'resources/assets/css/aos.css',
           'resources/assets/css/flatpickr.min.css',
           'resources/assets/css/layout.css',
           'resources/css/app.css',
           'resources/js/app.js',
        ])

     
        
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

                Alpine.store('drawer', {
                    active: false,
                    toggle() {
                        this.active = !this.active;
                        const layoutWrapper = document.querySelector('.layout-wrapper');
                        if (layoutWrapper) {
                            if (this.active) {
                                layoutWrapper.classList.add('active');
                            } else {
                                layoutWrapper.classList.remove('active');
                            }
                        }
                    }
                });

                // Navigation store n'est plus nécessaire car nous utilisons x-data local
            });


            // Navigation submenu géré par Alpine.js
            // La logique est maintenant dans les directives Alpine.js des éléments de navigation
            
            



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
    <body class="font-sans antialiased" x-data="{}" x-init="$store.darkMode.init()" @keydown.ctrl.b.window.prevent="$store.drawer.toggle()">
        <div class="layout-wrapper active w-full">
            <div class="relative flex w-full">
                <!-- Sidebar Navigation -->
                @auth
                    @include('layouts.sidebare')
                @endauth

               

                <!-- Main Content Container -->
                <div class="body-wrapper flex-1 overflow-x-hidden dark:bg-darkblack-500">
                    <!-- Top Navigation -->
                    @include('layouts.header')
                  
                    <!-- Main Content Container -->
                    <main role="main" class="w-full px-6 pb-6 pt-[100px] sm:pt-[156px] xl:px-12 xl:pb-12">
                         <!-- write your code here-->
                        <div class="2xl:flex 2xl:space-x-[48px]">
                            <section class="mb-6 w-full">

                                <!-- Page Heading -->
                                @if (isset($header))
                                    <div class="bg-white dark:bg-darkblack-600 rounded-lg p-4 mb-8">
                                        {{ $header }}
                                    </div>
                                @endif

                                <!-- Affichage des erreurs de validation en haut de la page -->
                                @if ($errors->any())
                                    <div class="mx-auto mt-4 px-4 sm:px-6 lg:px-8">
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

                                <div class="mx-auto">
                                    {{ $slot }}
                                </div>

                            </section>
                        </div>
                    </main>

                </div>
              
            </div>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    </body>
</html>
