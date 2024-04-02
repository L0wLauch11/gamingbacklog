@props(['value'])

<label {{ $attributes->merge(['class' => 'logon-text-label text-label']) }}>
    {{ $value ?? $slot }}
</label>
