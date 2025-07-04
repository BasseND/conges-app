<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary inline-flex items-center ']) }}>
    {{ $slot }}
</button>
