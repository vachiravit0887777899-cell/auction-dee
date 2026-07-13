<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] flex">
        <!-- Sidebar -->
        <aside class="w-56 bg-white border-r border-gray-100 shrink-0 hidden md:block">
            <nav class="p-4 space-y-1">
                <p class="text-xs font-semibold text-gray-400 uppercase px-3 mb-2">Admin Panel</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> ภาพรวม
                </a>
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i data-lucide="package" class="w-4 h-4"></i> จัดการสินค้า
                </a>
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i data-lucide="users" class="w-4 h-4"></i> จัดการผู้ใช้
                </a>
                <div class="pt-3 mt-3 border-t border-gray-100">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-gray-50">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> กลับหน้าเว็บ
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-6 lg:p-8">
            @if (session('success'))
                <div class="bg-success-500/10 text-success-500 border border-success-500/20 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-danger-500/10 text-danger-500 border border-danger-500/20 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</x-app-layout>