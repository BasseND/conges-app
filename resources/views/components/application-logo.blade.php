<img src="{{ asset('images/logo.png') }}" 
     class="block w-auto h-12 block dark:hidden "
     alt="Logo" 
     {{ $attributes->except('class') }}>
<img src="{{ asset('images/logo-dark.png') }}" 
     class="block w-auto h-12 hidden dark:block "
     alt="Logo" 
     {{ $attributes->except('class') }}>
