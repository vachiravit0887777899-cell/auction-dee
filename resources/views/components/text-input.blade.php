@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-vault-black border-vault-border focus:border-gold focus:ring-gold rounded shadow-sm text-sm py-2.5 text-ink-primary placeholder:text-ink-secondary/50 [color-scheme:dark]']) }}>