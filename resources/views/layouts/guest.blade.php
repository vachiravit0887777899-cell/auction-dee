<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Auction Dee') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    </head>
    <body class="font-sans antialiased bg-vault-black">
    <x-page-transition />
    <x-vault-atmosphere />
    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden py-10 z-10">

            <div class="absolute inset-0 opacity-70" style="background: radial-gradient(ellipse at 50% 30%, rgba(207,174,69,0.08), transparent 60%);"></div>
            <div class="absolute inset-0 opacity-70" style="background-image: radial-gradient(1px 1px at 20% 30%, rgba(207,174,69,0.5), transparent), radial-gradient(1px 1px at 60% 70%, rgba(207,174,69,0.4), transparent), radial-gradient(1px 1px at 80% 20%, rgba(207,174,69,0.3), transparent), radial-gradient(1px 1px at 40% 85%, rgba(207,174,69,0.4), transparent);"></div>

            <a href="{{ route('welcome') }}" class="relative flex items-center gap-2 mb-8">
                <div class="w-11 h-11 border border-gold/40 rounded flex items-center justify-center">
                    <i data-lucide="gem" class="w-5 h-5 text-gold-soft"></i>
                </div>
                <span class="font-serif font-bold text-2xl text-gold-soft tracking-wide">Auction Dee</span>
            </a>

            <div class="relative w-full sm:max-w-md px-6 py-8 bg-vault-obsidian border border-vault-border rounded">
                {{ $slot }}
            </div>

            <p class="relative text-ink-secondary/60 text-xs mt-8 uppercase tracking-widest">
                &copy; {{ date('Y') }} Auction Dee
            </p>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        </script>
    </body>
</html>