<nav role="navigation" aria-label="{{ __('Menu principal') }}" x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <!-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div> -->

                <!-- Bouton toggle sidebar -->
                <div class="hidden lg:flex lg:items-center lg:ml-4">
                    <button @click="$store.sidebar.toggle()" class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
                            <x-nav-link :href="route('admin.stats.index')" :active="request()->routeIs('admin.stats.*')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.leaves.index')" :active="request()->routeIs('admin.leaves.*')">
                                {{ __('Validation des congés') }}
                            </x-nav-link>
                             <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Gestion des utilisateurs') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')">
                                {{ __('Gestion des départements') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.company.show')" :active="request()->routeIs('admin.company.*')">
                                {{ __('Informations société') }}
                            </x-nav-link>
                            <!-- Menu déroulant pour les bulletins de paie -->
                            <div class="hidden sm:flex sm:items-center">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150 {{ request()->routeIs('admin.payslips.*') ? 'border-b-2 border-indigo-400 dark:border-indigo-600' : '' }}">
                                            <div>{{ __('Bulletins de paie') }}</div>
                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('admin.payslips.index')">
                                            {{ __('Liste des bulletins') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.payslips.create')">
                                            {{ __('Générer des bulletins') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.payslips.batch-validate-form')">
                                            {{ __('Validation en masse') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.payslips.batch-pdf-form')">
                                            {{ __('PDF en masse') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif

                        @if (auth()->user()->isManager())
                            <x-nav-link :href="route('manager.leaves.index')" :active="request()->routeIs('manager.leaves.*')">
                                {{ __('Gestion des congés') }}
                            </x-nav-link>
                        @endif

                        @if (auth()->user()->isDepartmentHead())
                            <x-nav-link :href="route('head.leaves.index')" :active="request()->routeIs('head.leaves.*')">
                                {{ __('Gestion des congés') }}
                            </x-nav-link>
                        @endif
                    @endauth
                    @auth
                        <x-nav-link :href="route('leaves.index')" :active="request()->routeIs('leaves.*')">
                            {{ __('Mes congés') }}
                        </x-nav-link>
                         <x-nav-link :href="route('expense-reports.index')" :active="request()->routeIs('expense-reports.*')">
                            {{ __('Notes de frais') }}
                        </x-nav-link>
                    @endauth
                    @auth
                       
                        <x-nav-link :href="route('payslips.index')" :active="request()->routeIs('payslips.*')">
                            {{ __('Mes bulletins de paie') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @auth
                    <!-- Notifications -->
                    <x-notification-bell :unreadCount="auth()->user()->notifications()->where('is_read', false)->count()" />
                    
                    <x-dropdown align="right" width="48"> 
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                <div>{{ Auth::user()->first_name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content" class="bg-white dark:bg-gray-800">
                            <!-- Dark Mode Toggle -->
                            <div class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <span>Mode sombre</span>
                                    <button type="button" 
                                        @click="$store.darkMode.toggle()"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-600"
                                        :class="$store.darkMode.on ? 'bg-indigo-600' : 'bg-gray-200'">
                                        <span class="sr-only">Activer le mode sombre</span>
                                        <span 
                                            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="$store.darkMode.on ? 'translate-x-5' : 'translate-x-0'">
                                            <span 
                                                class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                                :class="$store.darkMode.on ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in'">
                                                <!-- Icône soleil -->
                                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                    <path d="M6 1v1m0 8v1m-5-5h1m8 0h1M3 3l.7.7m4.6 4.6l.7.7M3 9l.7-.7m4.6-4.6L9 3M6 4a2 2 0 110 4 2 2 0 010-4z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            <span 
                                                class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                                :class="$store.darkMode.on ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out'">
                                                <!-- Icône lune -->
                                                <svg class="h-3 w-3 text-indigo-600" fill="none" viewBox="0 0 12 12">
                                                    <path d="M3.52 7.48a4 4 0 115.96-5.96 4 4 0 00-5.96 5.96z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <x-dropdown-link :href="route('profile.show')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
                    <x-responsive-nav-link :href="route('admin.stats.index')" :active="request()->routeIs('admin.stats.*')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.leaves.index')" :active="request()->routeIs('admin.leaves.*')">
                        {{ __('Validation des congés') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Gestion des utilisateurs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')">
                        {{ __('Gestion des départements') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.company.show')" :active="request()->routeIs('admin.company.*')">
                        {{ __('Informations société') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.payslips.index')" :active="request()->routeIs('admin.payslips.index')">
                        {{ __('Liste des bulletins') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.payslips.create')" :active="request()->routeIs('admin.payslips.create')">
                        {{ __('Générer des bulletins') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.payslips.batch-validate-form')" :active="request()->routeIs('admin.payslips.batch-validate-form')">
                        {{ __('Validation en masse') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.payslips.batch-pdf-form')" :active="request()->routeIs('admin.payslips.batch-pdf-form')">
                        {{ __('PDF en masse') }}
                    </x-responsive-nav-link>
                @endif

                @if (auth()->user()->isManager())
                    <x-responsive-nav-link :href="route('manager.leaves.index')" :active="request()->routeIs('manager.leaves.*')">
                        {{ __('Gestion des congés') }}
                    </x-responsive-nav-link>
                @endif

                @if (auth()->user()->isDepartmentHead())
                    <x-responsive-nav-link :href="route('head.leaves.index')" :active="request()->routeIs('head.leaves.*')">
                        {{ __('Gestion des congés') }}
                    </x-responsive-nav-link>
                @endif
                @auth
                    <x-responsive-nav-link :href="route('leaves.index')" :active="request()->routeIs('leaves.*')">
                        {{ __('Mes congés') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('expense-reports.index')" :active="request()->routeIs('expense-reports.*')">
                        {{ __('Notes de frais') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('payslips.index')" :active="request()->routeIs('payslips.*')">
                        {{ __('Mes bulletins de paie') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                        {{ __('Notifications') }}
                        @if(auth()->user()->notifications()->where('is_read', false)->count() > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                {{ auth()->user()->notifications()->where('is_read', false)->count() }}
                            </span>
                        @endif
                    </x-responsive-nav-link>
                @endauth

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-300">{{ Auth::user()->first_name }}</div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.show')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Connexion') }}
                </x-nav-link>
            </div>
        @endauth
    </div>
</nav>
