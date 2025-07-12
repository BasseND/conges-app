@props(['status'])

@if($status === 'pending')
    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
        En attente
    </div>
@elseif($status === 'approved')
    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
        Approuvé
    </div>
@elseif($status === 'rejected')
    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
        Rejeté
    </div>
@elseif($status === 'draft')
    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300">
        <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
        Brouillon
    </div>
@endif