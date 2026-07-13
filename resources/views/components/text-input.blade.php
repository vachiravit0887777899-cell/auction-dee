@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm text-sm py-2.5']) }}>