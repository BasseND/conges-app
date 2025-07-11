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
        @vite([
            'resources/assets/css/layout.css',
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    </head>
    <body>
       


        <section class="bg-white dark:bg-darkblack-500">
            <div class="flex flex-col lg:flex-row justify-between min-h-screen">
                <!-- Left -->
                <div class="lg:w-1/2 px-5 xl:pl-12 pt-10">
                   {{ $slot }}
                </div>
                <!-- Right -->
                <div class="lg:w-1/2 lg:block hidden bg-[#F6FAFF] dark:bg-darkblack-600 p-20 relative">
                    <ul>
                    <li class="absolute top-10 left-8">
                        <img src="{{ asset('images/shapes/square.svg') }}" alt="" />
                    </li>
                    <li class="absolute right-12 top-14">
                        <img src="{{ asset('images/shapes/vline.svg') }}" alt="" />
                    </li>
                    <li class="absolute bottom-7 left-8">
                        <img src="{{ asset('images/shapes/dotted.svg') }}" alt="" />
                    </li>
                    </ul>
                    <div class="">
                    <img
                        src="{{ asset('images/illustration/signin.svg') }}"
                        alt=""
                    />
                    </div>
                    <div>
                    <div class="text-center max-w-lg px-1.5 m-auto">
                        <h3
                        class="text-bgray-900 dark:text-white font-semibold font-popins text-4xl mb-4"
                        >
                        Simple, Rapide et Efficace
                        </h3>
                        <p class="text-bgray-600 dark:text-bgray-50 text-sm font-medium">
                        Notre plateforme complète vous aide à gérer vos congés, notes de frais,
                        paie et communications en toute simplicité. Soumettez vos demandes,
                        suivez leur statut et communiquez avec votre équipe grâce à la messagerie
                        intégrée. Profitez d'une <span class="text-success-300 font-bold">solution tout-en-un</span>
                        pour votre gestion RH
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </section>


    </body>
</html>



