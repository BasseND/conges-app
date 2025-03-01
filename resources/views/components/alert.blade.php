@props(['type' => 'success', 'message'])

@php
    $colors = [
        'success' => [
            'bg' => 'bg-green-100 dark:bg-green-800',
            'border' => 'border-green-400 dark:border-green-400',
            'text' => 'text-green-700 dark:text-green-400'
        ],
        'error' => [
            'bg' => 'bg-red-100 dark:bg-red-800',
            'border' => 'border-red-400 dark:border-red-400',
            'text' => 'text-red-700 dark:text-red-400'
        ],
        'warning' => [
            'bg' => 'bg-yellow-100 dark:bg-yellow-800',
            'border' => 'border-yellow-400 dark:border-yellow-400',
            'text' => 'text-yellow-700 dark:text-yellow-400'
        ],
        'info' => [
            'bg' => 'bg-blue-100 dark:bg-blue-800',
            'border' => 'border-blue-400 dark:border-blue-400',
            'text' => 'text-blue-700 dark:text-blue-400'
        ]
    ];
@endphp

@if($message)
    <div {{ $attributes->merge(['class' => "{$colors[$type]['bg']} border {$colors[$type]['border']} {$colors[$type]['text']} px-4 py-3 rounded relative mb-4"]) }} role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
@endif
