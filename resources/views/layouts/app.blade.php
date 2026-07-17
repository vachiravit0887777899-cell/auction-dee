<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    </head>
    <body class="font-sans antialiased bg-vault-black">
    <x-vault-entrance />
    <x-vault-atmosphere />
    <div class="min-h-screen text-ink-primary relative z-10">
        @include('layouts.navigation')
            <!-- Page Heading -->
            @isset($header)
    <header class="bg-vault-obsidian border-b border-vault-border">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endisset

            <!-- Page Content -->
            <main class="scene-in">
    {{ $slot }}
</main>
        </div>
        @stack('scripts') <script>lucide.createIcons();</script>
    </body>
</html>
