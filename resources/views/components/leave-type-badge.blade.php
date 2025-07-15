@props(['type', 'style' => 'default'])

@php
$classes = match($style) {
    'gradient' => match($type) {
        'annual' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white',
        'sick' => 'bg-gradient-to-r from-green-500 to-emerald-500 text-white',
        'maternity' => 'bg-gradient-to-r from-pink-500 to-pink-600 text-white',
        'paternity' => 'bg-gradient-to-r from-indigo-500 to-indigo-600 text-white',
        'unpaid' => 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white',
        default => 'bg-gradient-to-r from-gray-500 to-gray-600 text-white'
    },
    default => match($type) {
        'annual' => 'bg-blue-200 text-blue-900 dark:bg-blue-800 dark:text-blue-200',
        'sick' => 'bg-red-200 text-red-900 dark:bg-red-800 dark:text-red-200',
        'maternity' => 'bg-pink-200 text-pink-900 dark:bg-pink-800 dark:text-pink-200',
        'paternity' => 'bg-indigo-200 text-indigo-900 dark:bg-indigo-800 dark:text-indigo-200',
        'unpaid' => 'bg-yellow-200 text-yellow-900 dark:bg-yellow-800 dark:text-yellow-200',
        default => 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-700'
    }
};

$size = $style === 'gradient' ? 'px-4 py-2 rounded-xl text-sm font-bold shadow-lg' : 'px-3 py-2 rounded-lg text-sm font-semibold';
@endphp

<span class="inline-flex items-center {{ $size }} {{ $classes }}">
    @switch($type)
        @case('annual')
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Congé annuel
            @break
        @case('sick')
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Congé maladie
            @break
        @case('maternity')
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Congé maternité
            @break
        @case('paternity')
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Congé paternité
            @break
        @case('unpaid')
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            Congé sans solde
            @break
        @default
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Autre
    @endswitch
</span>