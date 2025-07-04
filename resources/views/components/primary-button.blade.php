<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary inline-flex items-center ']) }}>
    {{ $slot }}
</button>
