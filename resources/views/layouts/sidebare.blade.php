<aside
        class="sidebar-wrapper fixed top-0 z-30 block h-full w-[308px] bg-white dark:bg-darkblack-600 sm:hidden xl:block"
        x-data="{
            openMenus: {},
            init() {
                // Initialize the component
            },
            toggleSubmenu(menuId) {
                this.openMenus[menuId] = !this.openMenus[menuId];
            },
            isSubmenuOpen(menuId) {
                return this.openMenus[menuId] || false;
            }
        }"
    >
        <div
        class="sidebar-header relative z-30 flex h-[108px] w-full items-center border-b border-r border-b-[#F7F7F7] border-r-[#F7F7F7] pl-[50px] dark:border-darkblack-400"
        >
        <a href="{{ route('welcome.index') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
        <button
            type="button"
            class="drawer-btn absolute right-0 top-auto"
            title="Ctrl+b"
            @click="$store.drawer.toggle()"
        >
            <span>
            <svg
                width="16"
                height="40"
                viewBox="0 0 16 40"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M0 10C0 4.47715 4.47715 0 10 0H16V40H10C4.47715 40 0 35.5228 0 30V10Z"
                fill="#22C55E"
                />
                <path
                d="M10 15L6 20.0049L10 25.0098"
                stroke="#ffffff"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
                />
            </svg>
            </span>
        </button>
        </div>
        <div class="sidebar-body overflow-style-none relative z-30 h-screen w-full overflow-y-scroll pb-[200px] pl-[48px] pt-[14px]">
            <div class="nav-wrapper mb-[36px] pr-[50px]">
                <!-- Admin Menu -->
                
                    
                <div class="item-wrapper mb-5">
                    <h4 class="border-b border-bgray-200 text-sm font-medium leading-7 text-bgray-700 dark:border-darkblack-400 dark:text-bgray-50">
                        Menu 
                    </h4>
                    <ul class="mt-2.5">
                         @auth
                            @if (Auth::check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'hr'))
                                <!-- Settings -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('admin.company.show') }}" class="sidebar-link {{ request()->routeIs('admin.company.show') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                d="M13.0606 2H10.9394C9.76787 2 8.81817 2.89543 8.81817 4C8.81817 5.26401 7.46574 6.06763 6.35556 5.4633L6.24279 5.40192C5.22823 4.84963 3.93091 5.17738 3.34515 6.13397L2.28455 7.86602C1.69879 8.8226 2.0464 10.0458 3.06097 10.5981C4.17168 11.2027 4.17168 12.7973 3.06096 13.4019C2.0464 13.9542 1.69879 15.1774 2.28454 16.134L3.34515 17.866C3.93091 18.8226 5.22823 19.1504 6.24279 18.5981L6.35555 18.5367C7.46574 17.9324 8.81817 18.736 8.81817 20C8.81817 21.1046 9.76787 22 10.9394 22H13.0606C14.2321 22 15.1818 21.1046 15.1818 20C15.1818 18.736 16.5343 17.9324 17.6445 18.5367L17.7572 18.5981C18.7718 19.1504 20.0691 18.8226 20.6548 17.866L21.7155 16.134C22.3012 15.1774 21.9536 13.9542 20.939 13.4019C19.8283 12.7973 19.8283 11.2027 20.939 10.5981C21.9536 10.0458 22.3012 8.82262 21.7155 7.86603L20.6548 6.13398C20.0691 5.1774 18.7718 4.84965 17.7572 5.40193L17.6445 5.46331C16.5343 6.06765 15.1818 5.26402 15.1818 4C15.1818 2.89543 14.2321 2 13.0606 2Z"
                                                fill="#1A202C"
                                                class="path-1"
                                                />
                                                <path
                                                d="M15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92893 15.75 8.25 14.0711 8.25 12C8.25 9.92893 9.92893 8.25 12 8.25C14.0711 8.25 15.75 9.92893 15.75 12Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                            </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Paramètres</span
                                            >
                                        </div>
                                        </div>
                                    </a>
                                </li>

                                <!-- Dashboard -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('admin.stats.index') }}" class="sidebar-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 20 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M0 4C0 1.79086 1.79086 0 4 0H16C18.2091 0 20 1.79086 20 4V16C20 18.2091 18.2091 20 16 20H4C1.79086 20 0 18.2091 0 16V4Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        d="M14 9C12.8954 9 12 9.89543 12 11L12 13C12 14.1046 12.8954 15 14 15C15.1046 15 16 14.1046 16 13V11C16 9.89543 15.1046 9 14 9Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        d="M6 5C4.89543 5 4 5.89543 4 7L4 13C4 14.1046 4.89543 15 6 15C7.10457 15 8 14.1046 8 13L8 7C8 5.89543 7.10457 5 6 5Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                                <span
                                                class="item-text text-lg font-medium leading-none"
                                                >Dashboard</span
                                                >
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <!-- Gestion des users -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="#" @click.prevent="toggleSubmenu('employers')">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <ellipse
                                                cx="11.7778"
                                                cy="17.5555"
                                                rx="7.77778"
                                                ry="4.44444"
                                                class="path-1"
                                                fill="#1A202C"
                                                />
                                                <circle
                                                class="path-2"
                                                cx="11.7778"
                                                cy="6.44444"
                                                r="4.44444"
                                                fill="#22C55E"
                                                />
                                            </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Employés</span
                                            >
                                        </div>
                                        <span>
                                            <svg
                                            width="6"
                                            height="12"
                                            viewBox="0 0 6 12"
                                            fill="none"
                                            class="fill-current"
                                            xmlns="http://www.w3.org/2000/svg"
                                            >
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                fill="currentColor"
                                                d="M0.531506 0.414376C0.20806 0.673133 0.155619 1.1451 0.414376 1.46855L4.03956 6.00003L0.414376 10.5315C0.155618 10.855 0.208059 11.3269 0.531506 11.5857C0.854952 11.8444 1.32692 11.792 1.58568 11.4685L5.58568 6.46855C5.80481 6.19464 5.80481 5.80542 5.58568 5.53151L1.58568 0.531506C1.32692 0.20806 0.854953 0.155619 0.531506 0.414376Z"
                                            />
                                            </svg>
                                        </span>
                                        </div>
                                    </a>
                                    <ul
                                        class="sub-menu ml-2.5 mt-[22px] border-l border-success-100 pl-5"
                                        :class="{ 'active': isSubmenuOpen('employers') }"
                                        x-show="isSubmenuOpen('employers')"
                                        x-transition
                                    >
                                        <li>
                                        <a
                                            href="{{ route('admin.users.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.users.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Liste des employés</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('admin.departments.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.departments.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Entités</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('admin.contracts.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.contracts.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Contrats actifs</a
                                        >
                                        </li>
                                    
                                    </ul>
                                </li>

                                <!-- Gestion des Conges -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="#" @click.prevent="toggleSubmenu('leaves')">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg
                                                        width="18"
                                                        height="21"
                                                        viewBox="0 0 18 21"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                        fill="#1A202C"
                                                        class="path-2"
                                                        />
                                                        <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                        <circle
                                                        cx="13"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <circle
                                                        cx="5"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                                <span
                                                class="item-text text-lg font-medium leading-none"
                                                >Congés</span
                                                >
                                            </div>
                                            <span>
                                                <svg
                                                width="6"
                                                height="12"
                                                viewBox="0 0 6 12"
                                                fill="none"
                                                class="fill-current"
                                                xmlns="http://www.w3.org/2000/svg"
                                                >
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    fill="currentColor"
                                                    d="M0.531506 0.414376C0.20806 0.673133 0.155619 1.1451 0.414376 1.46855L4.03956 6.00003L0.414376 10.5315C0.155618 10.855 0.208059 11.3269 0.531506 11.5857C0.854952 11.8444 1.32692 11.792 1.58568 11.4685L5.58568 6.46855C5.80481 6.19464 5.80481 5.80542 5.58568 5.53151L1.58568 0.531506C1.32692 0.20806 0.854953 0.155619 0.531506 0.414376Z"
                                                />
                                                </svg>
                                            </span>
                                        </div>
                                    </a>
                                    <ul
                                        class="sub-menu ml-2.5 mt-[22px] border-l border-success-100 pl-5"
                                        :class="{ 'active': isSubmenuOpen('leaves') }"
                                        x-show="isSubmenuOpen('leaves')"
                                        x-transition
                                    >
                                        <li>
                                        <a
                                            href="{{ route('admin.leaves.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.leaves.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Validation des congés</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('leaves.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('leaves.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Mes congés</a
                                        >
                                        </li>
                                        @if (Auth::check() && auth()->user()->hasAdminAccess())
                                        <li>
                                        <a
                                            href="{{ route('admin.leave-balances.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.leave-balances.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Soldes de congés</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('admin.leave-balance-adjustments.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.leave-balance-adjustments.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Ajustements de soldes</a
                                        >
                                        </li>
                                        @endif
                                    
                                    </ul>
                                </li>

                                <!-- Note de frais -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('expense-reports.index') }}" class="sidebar-link {{ request()->routeIs('expense-reports.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="18"
                                                height="20"
                                                viewBox="0 0 18 20"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                fill="#1A202C"
                                                class="path-1"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                            </svg>
                                            </span>
                                            <span class="item-text text-lg font-medium leading-none">
                                                Note de frais
                                            </span>
                                        </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- Salaires -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="#" @click.prevent="toggleSubmenu('salary-advances')" class="sidebar-sublink {{ request()->routeIs('salary-advances.*' ) || request()->routeIs('admin.salary-advances.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20 4C20 1.79086 18.2091 0 16 0H4C1.79086 0 0 1.79086 0 4V14C0 16.2091 1.79086 18 4 18H16C18.2091 18 20 16.2091 20 14V4Z" fill="#1A202C" class="path-1"></path>
                                                        <path d="M6 9C6 7.34315 4.65685 6 3 6H0V12H3C4.65685 12 6 10.6569 6 9Z" fill="#22C55E" class="path-2"></path>
                                                    </svg>
                                                </span>
                                                <span
                                                class="item-text text-lg font-medium leading-none"
                                                >Salaires</span
                                                >
                                            </div>
                                            <span>
                                                <svg
                                                width="6"
                                                height="12"
                                                viewBox="0 0 6 12"
                                                fill="none"
                                                class="fill-current"
                                                xmlns="http://www.w3.org/2000/svg"
                                                >
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    fill="currentColor"
                                                    d="M0.531506 0.414376C0.20806 0.673133 0.155619 1.1451 0.414376 1.46855L4.03956 6.00003L0.414376 10.5315C0.155618 10.855 0.208059 11.3269 0.531506 11.5857C0.854952 11.8444 1.32692 11.792 1.58568 11.4685L5.58568 6.46855C5.80481 6.19464 5.80481 5.80542 5.58568 5.53151L1.58568 0.531506C1.32692 0.20806 0.854953 0.155619 0.531506 0.414376Z"
                                                />
                                                </svg>
                                            </span>
                                        </div>
                                    </a>
                                    <ul
                                        class="sub-menu ml-2.5 mt-[22px] border-l border-success-100 pl-5"
                                        :class="{ 'active': isSubmenuOpen('salary-advances') }"
                                        x-show="isSubmenuOpen('salary-advances')"
                                        x-transition
                                    >
                                        <li>
                                            <a
                                                href="{{ route('salary-advances.index') }}"
                                                class="sidebar-sublink {{ request()->routeIs('salary-advances.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                                > Avances sur salaire</a
                                            >
                                        </li>

                                        @if (Auth::check() && auth()->user()->isHR())
                                        <li>
                                            <a
                                                href="{{ route('admin.salary-advances.index') }}"
                                                class="sidebar-sublink {{ request()->routeIs('admin.salary-advances.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                                >Gestion des avances</a
                                            >
                                        </li>
                                        @endif
                                    
                                    </ul>
                                </li>

                                <!-- Attestations -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="#" @click.prevent="toggleSubmenu('attestations')">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg
                                                        width="18"
                                                        height="20"
                                                        viewBox="0 0 18 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                                <span
                                                class="item-text text-lg font-medium leading-none"
                                                >Attestations</span
                                                >
                                            </div>
                                            <span>
                                                <svg
                                                width="6"
                                                height="12"
                                                viewBox="0 0 6 12"
                                                fill="none"
                                                class="fill-current"
                                                xmlns="http://www.w3.org/2000/svg"
                                                >
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    fill="currentColor"
                                                    d="M0.531506 0.414376C0.20806 0.673133 0.155619 1.1451 0.414376 1.46855L4.03956 6.00003L0.414376 10.5315C0.155618 10.855 0.208059 11.3269 0.531506 11.5857C0.854952 11.8444 1.32692 11.792 1.58568 11.4685L5.58568 6.46855C5.80481 6.19464 5.80481 5.80542 5.58568 5.53151L1.58568 0.531506C1.32692 0.20806 0.854953 0.155619 0.531506 0.414376Z"
                                                />
                                                </svg>
                                            </span>
                                        </div>
                                    </a>
                                    <ul
                                        class="sub-menu ml-2.5 mt-[22px] border-l border-success-100 pl-5"
                                        :class="{ 'active': isSubmenuOpen('attestations') }"
                                        x-show="isSubmenuOpen('attestations')"
                                        x-transition
                                    >
                                        <li>
                                        <a
                                            href="{{ route('admin.attestations.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.attestations.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Gestion des attestations</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('admin.attestations.types.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.attestations.types.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Types d'attestations</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('attestations.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('attestations.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Mes attestations</a
                                        >
                                        </li>
                                        <li>
                                        <a
                                            href="{{ route('admin.hr-attestations.index') }}"
                                            class="sidebar-sublink {{ request()->routeIs('admin.hr-attestations.*') ? 'active' : '' }} text-md inline-block py-1.5 font-medium text-bgray-600 transition-all hover:text-bgray-800 dark:text-bgray-50 hover:dark:text-success-300"
                                            >Attestations RH</a
                                        >
                                        </li>
                                    
                                    </ul>
                                </li>

                            @else

                                <!-- Mes Conges -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('leaves.index') }}" class="sidebar-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="18"
                                                height="21"
                                                viewBox="0 0 18 21"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                fill="#1A202C"
                                                class="path-1"
                                                />
                                                <path
                                                d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                fill="#1A202C"
                                                class="path-2"
                                                />
                                                <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                <circle
                                                cx="13"
                                                cy="14"
                                                r="1"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <circle
                                                cx="5"
                                                cy="14"
                                                r="1"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                            </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Mes congés</span
                                            >
                                        </div>
                                        </div>
                                    </a>
                                </li>

                                
                                <!-- Gestion des congés -->
                                @if (Auth::check() && auth()->user()->isManager())
                                    <li class="item py-[11px] text-bgray-900 dark:text-white">
                                        <a href="{{ route('manager.leaves.index') }}" class="sidebar-link {{ request()->routeIs('manager.leaves.*') ? 'active' : '' }}">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg
                                                    width="18"
                                                    height="21"
                                                    viewBox="0 0 18 21"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                    <path
                                                        d="M17.5 12.5C17.5 17.1944 13.6944 21 9 21C4.30558 21 0.5 17.1944 0.5 12.5C0.5 7.80558 4.30558 4 9 4C13.6944 4 17.5 7.80558 17.5 12.5Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                    />
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M8.99995 1.75C8.02962 1.75 7.09197 1.88462 6.20407 2.13575C5.80549 2.24849 5.39099 2.01676 5.27826 1.61818C5.16553 1.21961 5.39725 0.805108 5.79583 0.692376C6.81525 0.404046 7.89023 0.25 8.99995 0.25C10.1097 0.25 11.1846 0.404046 12.2041 0.692376C12.6026 0.805108 12.8344 1.21961 12.7216 1.61818C12.6089 2.01676 12.1944 2.24849 11.7958 2.13575C10.9079 1.88462 9.97028 1.75 8.99995 1.75Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    <path
                                                        d="M11 13C11 14.1046 10.1046 15 9 15C7.89543 15 7 14.1046 7 13C7 11.8954 7.89543 11 9 11C10.1046 11 11 11.8954 11 13Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M9 7.25C9.41421 7.25 9.75 7.58579 9.75 8V12C9.75 12.4142 9.41421 12.75 9 12.75C8.58579 12.75 8.25 12.4142 8.25 12V8C8.25 7.58579 8.58579 7.25 9 7.25Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    </svg>
                                                </span>
                                                <span class="item-text text-lg font-medium leading-none">
                                                    {{ __('Gestion des congés') }}
                                                </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Gestion des congés -->
                                @if (Auth::check() && auth()->user()->isDepartmentHead())
                                    <li class="item py-[11px] text-bgray-900 dark:text-white">
                                        <a href="{{ route('head.leaves.index') }}" class="sidebar-link {{ request()->routeIs('head.leaves.*') ? 'active' : '' }}">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2.5">
                                                <span class="item-ico">
                                                    <svg
                                                    width="18"
                                                    height="21"
                                                    viewBox="0 0 18 21"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                    <path
                                                        d="M17.5 12.5C17.5 17.1944 13.6944 21 9 21C4.30558 21 0.5 17.1944 0.5 12.5C0.5 7.80558 4.30558 4 9 4C13.6944 4 17.5 7.80558 17.5 12.5Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                    />
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M8.99995 1.75C8.02962 1.75 7.09197 1.88462 6.20407 2.13575C5.80549 2.24849 5.39099 2.01676 5.27826 1.61818C5.16553 1.21961 5.39725 0.805108 5.79583 0.692376C6.81525 0.404046 7.89023 0.25 8.99995 0.25C10.1097 0.25 11.1846 0.404046 12.2041 0.692376C12.6026 0.805108 12.8344 1.21961 12.7216 1.61818C12.6089 2.01676 12.1944 2.24849 11.7958 2.13575C10.9079 1.88462 9.97028 1.75 8.99995 1.75Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    <path
                                                        d="M11 13C11 14.1046 10.1046 15 9 15C7.89543 15 7 14.1046 7 13C7 11.8954 7.89543 11 9 11C10.1046 11 11 11.8954 11 13Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M9 7.25C9.41421 7.25 9.75 7.58579 9.75 8V12C9.75 12.4142 9.41421 12.75 9 12.75C8.58579 12.75 8.25 12.4142 8.25 12V8C8.25 7.58579 8.58579 7.25 9 7.25Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                    />
                                                    </svg>
                                                </span>
                                                <span class="item-text text-lg font-medium leading-none">
                                                    {{ __('Gestion des congés') }}
                                                </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                                <!-- Note de frais -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('expense-reports.index') }}" class="sidebar-link {{ request()->routeIs('expense-reports.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="18"
                                                height="20"
                                                viewBox="0 0 18 20"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                fill="#1A202C"
                                                class="path-1"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                            </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Note de frais</span
                                            >
                                        </div>
                                        </div>
                                    </a>
                                </li>

                                <!-- Avances sur salaire -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('salary-advances.index') }}" class="sidebar-link {{ request()->routeIs('salary-advances.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 4C20 1.79086 18.2091 0 16 0H4C1.79086 0 0 1.79086 0 4V14C0 16.2091 1.79086 18 4 18H16C18.2091 18 20 16.2091 20 14V4Z" fill="#1A202C" class="path-1"></path>
                                                    <path d="M6 9C6 7.34315 4.65685 6 3 6H0V12H3C4.65685 12 6 10.6569 6 9Z" fill="#22C55E" class="path-2"></path>
                                                </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Avances sur salaire</span
                                            >
                                        </div>
                                        </div>
                                    </a>
                                </li>

                                <!-- Attestations -->
                                <li class="item py-[11px] text-bgray-900 dark:text-white">
                                    <a href="{{ route('attestations.index') }}" class="sidebar-link {{ request()->routeIs('attestations.*') ? 'active' : '' }}">
                                        <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="item-ico">
                                            <svg
                                                width="18"
                                                height="20"
                                                viewBox="0 0 18 20"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                fill="#1A202C"
                                                class="path-1"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                                <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                fill="#22C55E"
                                                class="path-2"
                                                />
                                            </svg>
                                            </span>
                                            <span
                                            class="item-text text-lg font-medium leading-none"
                                            >Attestations</span
                                            >
                                        </div>
                                        </div>
                                    </a>
                                </li>

                            @endif
                         @endauth

                    </ul>
                </div>
            
                <!-- End Admin Menu -->


                <!-- Menu Autres -->
                <div class="item-wrapper mb-5">
                    <h4 class="border-b border-bgray-200 text-sm font-medium leading-7 text-bgray-700 dark:border-darkblack-400 dark:text-bgray-50">
                        Autres
                    </h4>
                    <ul class="mt-2.5">
                         <!-- Messagerie -->


                         <li class="item py-[11px] text-bgray-900 dark:text-white" 
                             x-data="{ 
                                 unreadCount: 0,
                                 fetchUnreadCount() {
                                     fetch('{{ route('messages.unread-count') }}', {
                                         method: 'GET',
                                         headers: {
                                             'Accept': 'application/json',
                                             'X-Requested-With': 'XMLHttpRequest'
                                         },
                                         credentials: 'same-origin'
                                     })
                                     .then((response) => {
                                         if (response.ok) {
                                             // Vérifier si la réponse est bien du JSON
                                             const contentType = response.headers.get('content-type');
                                             if (contentType && contentType.includes('application/json')) {
                                                 return response.json();
                                             } else {
                                                 // Probablement une redirection vers la page de connexion
                                                 throw new Error('Réponse non-JSON reçue');
                                             }
                                         }
                                         throw new Error('Erreur réseau: ' + response.status);
                                     })
                                     .then((data) => {
                                         if (data && typeof data.count !== 'undefined') {
                                             this.unreadCount = data.count;
                                         }
                                     })
                                     .catch((error) => {
                                         console.error('Erreur lors de la récupération des messages non lus:', error);
                                         // Ne pas modifier unreadCount en cas d'erreur
                                     });
                                 }
                             }" 
                             x-init="
                                 // Récupérer le nombre initial après un délai pour s'assurer que l'authentification est complète
                                 setTimeout(() => fetchUnreadCount(), 1000);
                                 
                                 // Actualiser toutes les 30 secondes
                                 setInterval(() => fetchUnreadCount(), 30000);
                             ">
                            <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">

                              <div class="flex items-center justify-between">
                                <div class="flex space-x-2.5 items-center">
                                  <span class="item-ico">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M11.8889 22C13.4278 22 14.737 21.0724 15.2222 19.7778H8.55554C9.04075 21.0724 10.35 22 11.8889 22Z" fill="#22C55E" class="path-2"></path>
                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7662 2.83781C13.3045 2.32351 12.6345 2 11.8889 2C10.4959 2 9.36673 3.12921 9.36673 4.52216V4.6374C6.98629 5.45244 5.224 7.38959 4.95607 9.75021L4.4592 14.1281C4.36971 14.9165 4.03716 15.6684 3.49754 16.3024C2.27862 17.7343 3.43826 19.7778 5.46979 19.7778H18.308C20.3395 19.7778 21.4992 17.7343 20.2802 16.3024C19.7406 15.6684 19.4081 14.9165 19.3186 14.1281L18.8217 9.75021C18.8148 9.68916 18.8068 9.6284 18.7979 9.56793C18.3712 9.70421 17.9164 9.77778 17.4444 9.77778C14.9898 9.77778 13 7.78793 13 5.33333C13 4.40827 13.2826 3.54922 13.7662 2.83781Z" fill="#1A202C" class="path-1"></path>
                                      <circle cx="17.4444" cy="5.33333" r="3.33333" fill="#22C55E" class="path-2"></circle>
                                    </svg>
                                  </span>
                                  <span class="item-text text-lg font-medium leading-none">Messagerie</span>
                                </div>
                                <div class="flex space-x-2.5 items-center">
                                  <!--counter-->
                                  <div x-show="unreadCount > 0" class="w-5 h-5 rounded-full bg-success-300 flex justify-center items-center">
                                    <span  x-text="unreadCount" class="text-[10px] font-semibold text-white" x-cloak></span>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </li>
                        
                        <!-- Support -->
                        <li class="item py-[11px] text-bgray-900 dark:text-white">
                            <a href="{{ route('help.index') }}">
                                <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2.5">
                                    <span class="item-ico">
                                    <svg
                                        width="20"
                                        height="18"
                                        viewBox="0 0 20 18"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        d="M5 2V11C5 12.1046 5.89543 13 7 13H18C19.1046 13 20 12.1046 20 11V2C20 0.895431 19.1046 0 18 0H7C5.89543 0 5 0.89543 5 2Z"
                                        fill="#1A202C"
                                        class="path-1"
                                        />
                                        <path
                                        d="M0 15C0 13.8954 0.895431 13 2 13H2.17157C2.70201 13 3.21071 13.2107 3.58579 13.5858C4.36683 14.3668 5.63317 14.3668 6.41421 13.5858C6.78929 13.2107 7.29799 13 7.82843 13H8C9.10457 13 10 13.8954 10 15V16C10 17.1046 9.10457 18 8 18H2C0.89543 18 0 17.1046 0 16V15Z"
                                        fill="#22C55E"
                                        class="path-2"
                                        />
                                        <path
                                        d="M7.5 9.5C7.5 10.8807 6.38071 12 5 12C3.61929 12 2.5 10.8807 2.5 9.5C2.5 8.11929 3.61929 7 5 7C6.38071 7 7.5 8.11929 7.5 9.5Z"
                                        fill="#22C55E"
                                        class="path-2"
                                        />
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M8.25 4.5C8.25 4.08579 8.58579 3.75 9 3.75L16 3.75C16.4142 3.75 16.75 4.08579 16.75 4.5C16.75 4.91421 16.4142 5.25 16 5.25L9 5.25C8.58579 5.25 8.25 4.91421 8.25 4.5Z"
                                        fill="#22C55E"
                                        class="path-2"
                                        />
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M11.25 8.5C11.25 8.08579 11.5858 7.75 12 7.75L16 7.75C16.4142 7.75 16.75 8.08579 16.75 8.5C16.75 8.91421 16.4142 9.25 16 9.25L12 9.25C11.5858 9.25 11.25 8.91421 11.25 8.5Z"
                                        fill="#22C55E"
                                        class="path-2"
                                        />
                                    </svg>
                                    </span>
                                    <span
                                    class="item-text text-lg font-medium leading-none"
                                    >Aides</span
                                    >
                                </div>
                                </div>
                            </a>
                        </li>
                        <!-- Déconnexion -->
                        <li class="item py-[11px] text-bgray-900 dark:text-white">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2.5">
                                        <span class="item-ico">
                                        <svg
                                            width="21"
                                            height="18"
                                            viewBox="0 0 21 18"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M17.1464 10.4394C16.8536 10.7323 16.8536 11.2072 17.1464 11.5001C17.4393 11.7929 17.9142 11.7929 18.2071 11.5001L19.5 10.2072C20.1834 9.52375 20.1834 8.41571 19.5 7.73229L18.2071 6.4394C17.9142 6.1465 17.4393 6.1465 17.1464 6.4394C16.8536 6.73229 16.8536 7.20716 17.1464 7.50006L17.8661 8.21973H11.75C11.3358 8.21973 11 8.55551 11 8.96973C11 9.38394 11.3358 9.71973 11.75 9.71973H17.8661L17.1464 10.4394Z"
                                            fill="#22C55E"
                                            class="path-2"
                                            />
                                            <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M4.75 17.75H12C14.6234 17.75 16.75 15.6234 16.75 13C16.75 12.5858 16.4142 12.25 16 12.25C15.5858 12.25 15.25 12.5858 15.25 13C15.25 14.7949 13.7949 16.25 12 16.25H8.21412C7.34758 17.1733 6.11614 17.75 4.75 17.75ZM8.21412 1.75H12C13.7949 1.75 15.25 3.20507 15.25 5C15.25 5.41421 15.5858 5.75 16 5.75C16.4142 5.75 16.75 5.41421 16.75 5C16.75 2.37665 14.6234 0.25 12 0.25H4.75C6.11614 0.25 7.34758 0.82673 8.21412 1.75Z"
                                            fill="#1A202C"
                                            class="path-1"
                                            />
                                            <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M0 5C0 2.37665 2.12665 0.25 4.75 0.25C7.37335 0.25 9.5 2.37665 9.5 5V13C9.5 15.6234 7.37335 17.75 4.75 17.75C2.12665 17.75 0 15.6234 0 13V5Z"
                                            fill="#1A202C"
                                            class="path-1"
                                            />
                                        </svg>
                                        </span>
                                        <span
                                        class="item-text text-lg font-medium leading-none"
                                        >Se deconnecter</span
                                        >
                                    </div>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            
            </div>
        
    
            <!-- Copywrite -->
            <div class="copy-write-text">
                <p class="text-sm text-[#969BA0]">© {{ date('Y') }} RH Connect. <br> Tous droits réservés.</p>
            </div>
        </div>
    </aside>

    <!-- Overlay -->
    <div style="z-index: 25" class="aside-overlay fixed left-0 top-0 block h-full w-full bg-black bg-opacity-30 sm:hidden">
    </div>

    <!-- Menu Mobile -->
    <aside class="relative hidden w-[96px] bg-white dark:bg-black sm:block">
        <div class="sidebar-wrapper-collapse relative top-0 z-30 w-full">
            <div class="sidebar-header sticky top-0 z-20 flex h-[108px] w-full items-center justify-center border-b border-r border-b-[#F7F7F7] border-r-[#F7F7F7] bg-white dark:border-darkblack-500 dark:bg-darkblack-600">
                <!-- Logo Mobile -->
                <a href="index.html">
                    <x-application-logo-mobile />
                </a>
            </div>
            <div class="sidebar-body w-full pt-[14px]">
                <div class="flex flex-col items-center">
                    <div class="nav-wrapper mb-[36px]">
                        <div class="item-wrapper mb-5">
                            <ul class="mt-2.5 flex flex-col items-center justify-center">
                                @auth
                                    @if (Auth::check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'hr'))
                                    <!-- Paramètres -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('admin.company.show') }}">
                                                <span class="item-ico">
                                                    <svg
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M13.0606 2H10.9394C9.76787 2 8.81817 2.89543 8.81817 4C8.81817 5.26401 7.46574 6.06763 6.35556 5.4633L6.24279 5.40192C5.22823 4.84963 3.93091 5.17738 3.34515 6.13397L2.28455 7.86602C1.69879 8.8226 2.0464 10.0458 3.06097 10.5981C4.17168 11.2027 4.17168 12.7973 3.06096 13.4019C2.0464 13.9542 1.69879 15.1774 2.28454 16.134L3.34515 17.866C3.93091 18.8226 5.22823 19.1504 6.24279 18.5981L6.35555 18.5367C7.46574 17.9324 8.81817 18.736 8.81817 20C8.81817 21.1046 9.76787 22 10.9394 22H13.0606C14.2321 22 15.1818 21.1046 15.1818 20C15.1818 18.736 16.5343 17.9324 17.6445 18.5367L17.7572 18.5981C18.7718 19.1504 20.0691 18.8226 20.6548 17.866L21.7155 16.134C22.3012 15.1774 21.9536 13.9542 20.939 13.4019C19.8283 12.7973 19.8283 11.2027 20.939 10.5981C21.9536 10.0458 22.3012 8.82262 21.7155 7.86603L20.6548 6.13398C20.0691 5.1774 18.7718 4.84965 17.7572 5.40193L17.6445 5.46331C16.5343 6.06765 15.1818 5.26402 15.1818 4C15.1818 2.89543 14.2321 2 13.0606 2Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        d="M15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92893 15.75 8.25 14.0711 8.25 12C8.25 9.92893 9.92893 8.25 12 8.25C14.0711 8.25 15.75 9.92893 15.75 12Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                </svg>
                                                </span>
                                            </a>
                                        </li>
                                        <!-- Dashboard -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('admin.stats.index') }}">
                                                <span class="item-ico">
                                                <svg
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 20 20"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                    d="M0 4C0 1.79086 1.79086 0 4 0H16C18.2091 0 20 1.79086 20 4V16C20 18.2091 18.2091 20 16 20H4C1.79086 20 0 18.2091 0 16V4Z"
                                                    fill="#1A202C"
                                                    class="path-1"
                                                    />
                                                    <path
                                                    d="M14 9C12.8954 9 12 9.89543 12 11L12 13C12 14.1046 12.8954 15 14 15C15.1046 15 16 14.1046 16 13V11C16 9.89543 15.1046 9 14 9Z"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                    <path
                                                    d="M6 5C4.89543 5 4 5.89543 4 7L4 13C4 14.1046 4.89543 15 6 15C7.10457 15 8 14.1046 8 13L8 7C8 5.89543 7.10457 5 6 5Z"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                </svg>
                                                </span>
                                            </a>
                                        </li>
                                        <!-- Employees -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="javascript:void(0);">
                                                <span class="item-ico">
                                                    <svg
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <ellipse
                                                        cx="11.7778"
                                                        cy="17.5555"
                                                        rx="7.77778"
                                                        ry="4.44444"
                                                        class="path-1"
                                                        fill="#1A202C"
                                                        />
                                                        <circle
                                                        class="path-2"
                                                        cx="11.7778"
                                                        cy="6.44444"
                                                        r="4.44444"
                                                        fill="#22C55E"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                            <ul
                                                class="sub-menu min-w-[200px] rounded-lg border-l border-success-100 bg-white px-5 py-2 shadow-lg"
                                            
                                            >
                                                <li>
                                                <a
                                                    href="{{ route('admin.users.index') }}"
                                                    class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                    >Liste des employés</a
                                                >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('admin.departments.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Entités</a
                                                    >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('admin.contracts.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Contrats actifs</a
                                                    >
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Gestion des Congés -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="javascript:void(0);">
                                                <span class="item-ico">
                                                    <svg
                                                    width="18"
                                                    height="21"
                                                    viewBox="0 0 18 21"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                        fill="#1A202C"
                                                        class="path-2"
                                                        />
                                                        <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                        <circle
                                                        cx="13"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <circle
                                                        cx="5"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                            <ul
                                                class="sub-menu min-w-[200px] rounded-lg border-l border-success-100 bg-white px-5 py-2 shadow-lg"
                                            
                                            >
                                                <li>
                                                <a
                                                    href="{{ route('admin.leaves.index') }}"
                                                    class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                    >Validation des congés</a
                                                >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('leaves.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Mes congés</a
                                                    >
                                                </li>
                                           
                                            </ul>
                                        </li>
                                        <!-- Attestations -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="javascript:void(0);">
                                                <span class="item-ico">
                                                    <svg
                                                        width="18"
                                                        height="20"
                                                        viewBox="0 0 18 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                            <ul
                                                class="sub-menu min-w-[200px] rounded-lg border-l border-success-100 bg-white px-5 py-2 shadow-lg"
                                            
                                            >
                                                <li>
                                                <a
                                                    href="{{ route('admin.attestations.index') }}"
                                                    class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                    >Gestion des attestations</a
                                                >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('admin.attestations.types.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Types d'attestations</a
                                                    >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('attestations.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Mes attestations</a
                                                    >
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('admin.hr-attestations.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Attestations RH</a
                                                    >
                                                </li>
                                           
                                            </ul>
                                        </li>
                                        <!-- Notes de frais -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('expense-reports.index') }}">
                                                <span class="item-ico">
                                                    <svg
                                                        width="18"
                                                        height="20"
                                                        viewBox="0 0 18 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                        </li>
                                       

                                         <!-- Salaires -->
                                         <li class="item px-[43px] py-[11px]">
                                            <a href="javascript:void(0);">
                                                <span class="item-ico">
                                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20 4C20 1.79086 18.2091 0 16 0H4C1.79086 0 0 1.79086 0 4V14C0 16.2091 1.79086 18 4 18H16C18.2091 18 20 16.2091 20 14V4Z" fill="#1A202C" class="path-1"></path>
                                                        <path d="M6 9C6 7.34315 4.65685 6 3 6H0V12H3C4.65685 12 6 10.6569 6 9Z" fill="#22C55E" class="path-2"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <ul
                                                class="sub-menu min-w-[200px] rounded-lg border-l border-success-100 bg-white px-5 py-2 shadow-lg"
                                            
                                            >

                                               @if (Auth::check() && auth()->user()->isHR())
                                                <li>
                                                <a
                                                    href="{{ route('salary-advances.index') }}"
                                                    class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                    >Avances sur salaire</a
                                                >
                                                </li>
                                                @endif
                                                <li>
                                                    <a
                                                        href="{{ route('admin.salary-advances.index') }}"
                                                        class="text-md inline-block py-1.5 font-medium text-bgray-600 hover:text-bgray-800"
                                                        >Gestion des accomptes</a
                                                    >
                                                </li>
                                               
                                            </ul>
                                        </li>

                                    @else
                                        <!-- Congés -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('leaves.index') }}">
                                                <span class="item-ico">
                                                <svg
                                                    width="18"
                                                    height="21"
                                                    viewBox="0 0 18 21"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                    d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                    fill="#1A202C"
                                                    class="path-1"
                                                    />
                                                    <path
                                                    d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                    <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                    fill="#1A202C"
                                                    class="path-2"
                                                    />
                                                    <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                    <circle
                                                    cx="13"
                                                    cy="14"
                                                    r="1"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                    <circle
                                                    cx="5"
                                                    cy="14"
                                                    r="1"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                </svg>
                                                </span>
                                            </a>
                                        </li>
                                        <!-- Gestion des congés Manager -->
                                        @if (Auth::check() && auth()->user()->isManager())
                                        <li class="item px-[43px] py-[11px]">
                                                <a href="{{ route('manager.leaves.index') }}">
                                                    <span class="item-ico">
                                                        <svg
                                                        width="18"
                                                        height="21"
                                                        viewBox="0 0 18 21"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                            d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                            fill="#1A202C"
                                                            class="path-1"
                                                            />
                                                            <path
                                                            d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                            fill="#22C55E"
                                                            class="path-2"
                                                            />
                                                            <path
                                                            fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                            fill="#1A202C"
                                                            class="path-2"
                                                            />
                                                            <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                            <circle
                                                            cx="13"
                                                            cy="14"
                                                            r="1"
                                                            fill="#22C55E"
                                                            class="path-2"
                                                            />
                                                            <circle
                                                            cx="5"
                                                            cy="14"
                                                            r="1"
                                                            fill="#22C55E"
                                                            class="path-2"
                                                            />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                        <!-- Gestion des congés Chef Departement -->
                                        @if (Auth::check() && auth()->user()->isDepartmentHead())
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('head.leaves.index') }}">
                                                <span class="item-ico">
                                                    <svg
                                                    width="18"
                                                    height="21"
                                                    viewBox="0 0 18 21"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M0 6.5C0 4.29086 1.79086 2.5 4 2.5H14C16.2091 2.5 18 4.29086 18 6.5V8V17C18 19.2091 16.2091 21 14 21H4C1.79086 21 0 19.2091 0 17V8V6.5Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        d="M14 2.5H4C1.79086 2.5 0 4.29086 0 6.5V8H18V6.5C18 4.29086 16.2091 2.5 14 2.5Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M5 0.25C5.41421 0.25 5.75 0.585786 5.75 1V4C5.75 4.41421 5.41421 4.75 5 4.75C4.58579 4.75 4.25 4.41421 4.25 4V1C4.25 0.585786 4.58579 0.25 5 0.25ZM13 0.25C13.4142 0.25 13.75 0.585786 13.75 1V4C13.75 4.41421 13.4142 4.75 13 4.75C12.5858 4.75 12.25 4.41421 12.25 4V1C12.25 0.585786 12.5858 0.25 13 0.25Z"
                                                        fill="#1A202C"
                                                        class="path-2"
                                                        />
                                                        <circle cx="9" cy="14" r="1" fill="#22C55E" />
                                                        <circle
                                                        cx="13"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <circle
                                                        cx="5"
                                                        cy="14"
                                                        r="1"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                        </li>
                                        @endif

                                        <!-- Notes de frais -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('expense-reports.index') }}">
                                                <span class="item-ico">
                                                    <svg
                                                        width="18"
                                                        height="20"
                                                        viewBox="0 0 18 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M18 16V6C18 3.79086 16.2091 2 14 2H4C1.79086 2 0 3.79086 0 6V16C0 18.2091 1.79086 20 4 20H14C16.2091 20 18 18.2091 18 16Z"
                                                        fill="#1A202C"
                                                        class="path-1"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 8C4.25 7.58579 4.58579 7.25 5 7.25H13C13.4142 7.25 13.75 7.58579 13.75 8C13.75 8.41421 13.4142 8.75 13 8.75H5C4.58579 8.75 4.25 8.41421 4.25 8Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H13C13.4142 11.25 13.75 11.5858 13.75 12C13.75 12.4142 13.4142 12.75 13 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.25 16C4.25 15.5858 4.58579 15.25 5 15.25H9C9.41421 15.25 9.75 15.5858 9.75 16C9.75 16.4142 9.41421 16.75 9 16.75H5C4.58579 16.75 4.25 16.4142 4.25 16Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                        <path
                                                        d="M11 0H7C5.89543 0 5 0.895431 5 2C5 3.10457 5.89543 4 7 4H11C12.1046 4 13 3.10457 13 2C13 0.895431 12.1046 0 11 0Z"
                                                        fill="#22C55E"
                                                        class="path-2"
                                                        />
                                                    </svg>
                                                </span>
                                            </a>
                                        </li>

                                         <!-- Avances sur salaire -->
                                         <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('salary-advances.index') }}">
                                                <span class="item-ico">
                                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20 4C20 1.79086 18.2091 0 16 0H4C1.79086 0 0 1.79086 0 4V14C0 16.2091 1.79086 18 4 18H16C18.2091 18 20 16.2091 20 14V4Z" fill="#1A202C" class="path-1"></path>
                                                        <path d="M6 9C6 7.34315 4.65685 6 3 6H0V12H3C4.65685 12 6 10.6569 6 9Z" fill="#22C55E" class="path-2"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                         </li>

                                        <!-- Attestations -->
                                        <li class="item px-[43px] py-[11px]">
                                            <a href="{{ route('attestations.index') }}">
                                                <span class="item-ico">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 0C1.79086 0 0 1.79086 0 4V16C0 18.2091 1.79086 20 4 20H16C18.2091 20 20 18.2091 20 16V4C20 1.79086 18.2091 0 16 0H4Z" fill="#1A202C" class="path-1"/>
                                                        <path d="M6 6C5.44772 6 5 6.44772 5 7C5 7.55228 5.44772 8 6 8H14C14.5523 8 15 7.55228 15 7C15 6.44772 14.5523 6 14 6H6Z" fill="#22C55E" class="path-2"/>
                                                        <path d="M6 10C5.44772 10 5 10.4477 5 11C5 11.5523 5.44772 12 6 12H14C14.5523 12 15 11.5523 15 11C15 10.4477 14.5523 10 14 10H6Z" fill="#22C55E" class="path-2"/>
                                                        <path d="M6 14C5.44772 14 5 14.4477 5 15C5 15.5523 5.44772 16 6 16H10C10.5523 16 11 15.5523 11 15C11 14.4477 10.5523 14 10 14H6Z" fill="#22C55E" class="path-2"/>
                                                        <circle cx="15" cy="5" r="3" fill="#22C55E" class="path-2"/>
                                                        <path d="M13.5 5L14.5 6L16.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                            </a>
                                        </li>

                                    @endif
                                @endauth
                            </ul>
                        </div>

                        <!-- Autres -->
                        <div class="item-wrapper mb-5">
                            <ul class="mt-2.5 flex flex-col items-center justify-center">
                                 <!-- Messages -->
                                 <li class="item px-[43px] py-[11px]">
                                    <a href="{{ route('messages.index') }}">
                                        <span class="item-ico">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                              <path d="M11.8889 22C13.4278 22 14.737 21.0724 15.2222 19.7778H8.55554C9.04075 21.0724 10.35 22 11.8889 22Z" fill="#22C55E" class="path-2"></path>
                                              <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7662 2.83781C13.3045 2.32351 12.6345 2 11.8889 2C10.4959 2 9.36673 3.12921 9.36673 4.52216V4.6374C6.98629 5.45244 5.224 7.38959 4.95607 9.75021L4.4592 14.1281C4.36971 14.9165 4.03716 15.6684 3.49754 16.3024C2.27862 17.7343 3.43826 19.7778 5.46979 19.7778H18.308C20.3395 19.7778 21.4992 17.7343 20.2802 16.3024C19.7406 15.6684 19.4081 14.9165 19.3186 14.1281L18.8217 9.75021C18.8148 9.68916 18.8068 9.6284 18.7979 9.56793C18.3712 9.70421 17.9164 9.77778 17.4444 9.77778C14.9898 9.77778 13 7.78793 13 5.33333C13 4.40827 13.2826 3.54922 13.7662 2.83781Z" fill="#1A202C" class="path-1"></path>
                                              <circle cx="17.4444" cy="5.33333" r="3.33333" fill="#22C55E" class="path-2"></circle>
                                            </svg>
                                        </span>
                                    </a>
                                </li>

                                <!-- Support -->
                                <li class="item px-[43px] py-[11px]">
                                    <a href="{{ route('help.index') }}">
                                        <span class="item-ico">
                                            <svg
                                            width="20"
                                            height="18"
                                            viewBox="0 0 20 18"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                            d="M5 2V11C5 12.1046 5.89543 13 7 13H18C19.1046 13 20 12.1046 20 11V2C20 0.895431 19.1046 0 18 0H7C5.89543 0 5 0.89543 5 2Z"
                                            fill="#1A202C"
                                            class="path-1"
                                            />
                                            <path
                                            d="M0 15C0 13.8954 0.895431 13 2 13H2.17157C2.70201 13 3.21071 13.2107 3.58579 13.5858C4.36683 14.3668 5.63317 14.3668 6.41421 13.5858C6.78929 13.2107 7.29799 13 7.82843 13H8C9.10457 13 10 13.8954 10 15V16C10 17.1046 9.10457 18 8 18H2C0.89543 18 0 17.1046 0 16V15Z"
                                            fill="#22C55E"
                                            class="path-2"
                                            />
                                            <path
                                            d="M7.5 9.5C7.5 10.8807 6.38071 12 5 12C3.61929 12 2.5 10.8807 2.5 9.5C2.5 8.11929 3.61929 7 5 7C6.38071 7 7.5 8.11929 7.5 9.5Z"
                                            fill="#22C55E"
                                            class="path-2"
                                            />
                                            <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M8.25 4.5C8.25 4.08579 8.58579 3.75 9 3.75L16 3.75C16.4142 3.75 16.75 4.08579 16.75 4.5C16.75 4.91421 16.4142 5.25 16 5.25L9 5.25C8.58579 5.25 8.25 4.91421 8.25 4.5Z"
                                            fill="#22C55E"
                                            class="path-2"
                                            />
                                            <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M11.25 8.5C11.25 8.08579 11.5858 7.75 12 7.75L16 7.75C16.4142 7.75 16.75 8.08579 16.75 8.5C16.75 8.91421 16.4142 9.25 16 9.25L12 9.25C11.5858 9.25 11.25 8.91421 11.25 8.5Z"
                                            fill="#22C55E"
                                            class="path-2"/>
                                            </svg>
                                        </span>
                                    </a>
                                </li>

                                <!-- Déconnexion -->
                                <li class="item px-[43px] py-[11px]">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit">
                                            <span class="item-ico">
                                                <svg
                                                    width="21"
                                                    height="18"
                                                    viewBox="0 0 21 18"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M17.1464 10.4394C16.8536 10.7323 16.8536 11.2072 17.1464 11.5001C17.4393 11.7929 17.9142 11.7929 18.2071 11.5001L19.5 10.2072C20.1834 9.52375 20.1834 8.41571 19.5 7.73229L18.2071 6.4394C17.9142 6.1465 17.4393 6.1465 17.1464 6.4394C16.8536 6.73229 16.8536 7.20716 17.1464 7.50006L17.8661 8.21973H11.75C11.3358 8.21973 11 8.55551 11 8.96973C11 9.38394 11.3358 9.71973 11.75 9.71973H17.8661L17.1464 10.4394Z"
                                                    fill="#22C55E"
                                                    class="path-2"
                                                    />
                                                    <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M4.75 17.75H12C14.6234 17.75 16.75 15.6234 16.75 13C16.75 12.5858 16.4142 12.25 16 12.25C15.5858 12.25 15.25 12.5858 15.25 13C15.25 14.7949 13.7949 16.25 12 16.25H8.21412C7.34758 17.1733 6.11614 17.75 4.75 17.75ZM8.21412 1.75H12C13.7949 1.75 15.25 3.20507 15.25 5C15.25 5.41421 15.5858 5.75 16 5.75C16.4142 5.75 16.75 5.41421 16.75 5C16.75 2.37665 14.6234 0.25 12 0.25H4.75C6.11614 0.25 7.34758 0.82673 8.21412 1.75Z"
                                                    fill="#1A202C"
                                                    class="path-1"
                                                    />
                                                    <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M0 5C0 2.37665 2.12665 0.25 4.75 0.25C7.37335 0.25 9.5 2.37665 9.5 5V13C9.5 15.6234 7.37335 17.75 4.75 17.75C2.12665 17.75 0 15.6234 0 13V5Z"
                                                    fill="#1A202C"
                                                    class="path-1"
                                                    />
                                                </svg>
                                            </span>
                                        </button>
                                </form>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

                
    </aside>
