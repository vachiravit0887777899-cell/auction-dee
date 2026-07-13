<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Auction Dee') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-primary-700 via-primary-600 to-accent-500 relative overflow-hidden py-10">

            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>

            <!-- Logo -->
            <a href="{{ route('welcome') }}" class="relative flex items-center gap-2 mb-8">
                <div class="w-11 h-11 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                    <i data-lucide="gavel" class="w-6 h-6 text-white"></i>
                </div>
                <span class="font-extrabold text-2xl text-white tracking-tight">Auction Dee</span>
            </a>

            <!-- Card -->
            <div class="relative w-full sm:max-w-md px-6 py-8 bg-white shadow-card rounded-xl2 border border-gray-100">
                {{ $slot }}
            </div>

            <p class="relative text-white/60 text-xs mt-8">
                &copy; {{ date('Y') }} Auction Dee. All rights reserved.
            </p>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        </script>
    </body>
</html>