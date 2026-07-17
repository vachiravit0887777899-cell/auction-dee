@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[10px] uppercase tracking-widest text-ink-secondary mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>