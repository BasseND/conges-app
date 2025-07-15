<div class="hidden lg:flex items-center space-x-3">
  <!-- Icône de la société -->
  <div class="flex-shrink-0">
    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-xl shadow-lg mr-2">
    <svg class="w-6 h-6 text-white dark:text-bgray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
    </svg>
    </div>
  </div>
  
  <!-- Informations de la société -->
  <div class="flex flex-col">
    <h3 class="text-xl font-bold text-bgray-900 dark:text-bgray-50 lg:text-3xl lg:leading-[36.4px]">
      {{ $globalCompanyName }}
    </h3>
    <p class="text-xs font-medium text-bgray-600 dark:text-bgray-50 lg:text-sm lg:leading-[25.2px]">
      {{ $globalCompanyAddress }}
    </p>
  </div>
</div>