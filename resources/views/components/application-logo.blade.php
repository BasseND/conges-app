<img src="{{ asset('images/logo/logo-color.svg') }}" 
     class="block w-auto h-16 block dark:hidden "
     alt="Logo" 
     {{ $attributes->except('class') }}>
<img src="{{ asset('images/logo/logo-white.svg') }}" 
     class="block w-auto h-16 hidden dark:block "
     alt="Logo" 
     {{ $attributes->except('class') }}>
