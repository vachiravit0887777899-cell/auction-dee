<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] flex bg-vault-black">
        <aside class="w-56 bg-vault-obsidian border-r border-vault-border shrink-0 hidden md:block">
            <nav class="p-4 space-y-1">
                <p class="text-[10px] uppercase tracking-widest text-ink-secondary px-3 mb-3">Admin Panel</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded text-xs uppercase tracking-widest transition {{ request()->routeIs('admin.dashboard') ? 'bg-gold/10 text-gold-soft border border-gold/20' : 'text-ink-secondary hover:bg-vault-stone' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> ภาพรวม
                </a>
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded text-xs uppercase tracking-widest transition {{ request()->routeIs('admin.products') ? 'bg-gold/10 text-gold-soft border border-gold/20' : 'text-ink-secondary hover:bg-vault-stone' }}">
                    <i data-lucide="package" class="w-4 h-4"></i> จัดการสินค้า
                </a>
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded text-xs uppercase tracking-widest transition {{ request()->routeIs('admin.users') ? 'bg-gold/10 text-gold-soft border border-gold/20' : 'text-ink-secondary hover:bg-vault-stone' }}">
                    <i data-lucide="users" class="w-4 h-4"></i> จัดการผู้ใช้
                </a>
                <div class="pt-3 mt-3 border-t border-vault-border">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded text-xs uppercase tracking-widest text-ink-secondary/60 hover:bg-vault-stone">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> กลับหน้าเว็บ
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-1 p-6 lg:p-8">
            @if (session('success'))
                <div class="bg-gold/10 text-gold-soft border border-gold/30 px-4 py-3 rounded mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-500/10 text-red-400 border border-red-500/20 px-4 py-3 rounded mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</x-app-layout>