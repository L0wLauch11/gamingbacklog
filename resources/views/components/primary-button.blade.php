<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button logon-button']) }}>
    {{ $slot }}
</button>
