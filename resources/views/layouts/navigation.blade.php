<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 shadow-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 flex items-center justify-center">
                        <i data-lucide="gavel" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="font-extrabold text-lg text-gray-900 tracking-tight hidden sm:block">Auction Dee</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('products.index') || request()->routeIs('products.show') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        สินค้าประมูล
                    </a>
                    @if (auth()->check() && auth()->user()->is_admin)
<a href="{{ route('admin.dashboard') }}"
   class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
    Admin
</a>
@endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <!-- ปุ่มลงประมูล (gradient เด่น) -->
                    <a href="{{ route('products.create') }}"
                       class="hidden sm:flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:shadow-lg hover:shadow-primary-500/30 transition-all duration-200">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        ลงประมูล
                    </a>

                    <!-- Notifications -->
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="80">
                            <x-slot name="trigger">
                                <button class="relative w-10 h-10 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                                    <i data-lucide="bell" class="w-5 h-5"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-danger-500 rounded-full ring-2 ring-white"></span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">การแจ้งเตือน</p>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    @forelse (auth()->user()->notifications()->latest()->limit(10)->get() as $notification)
                                        <div class="px-4 py-3 text-sm border-b border-gray-50 last:border-0 {{ $notification->read_at ? 'text-gray-500' : 'text-gray-900 font-medium bg-primary-50/50' }}">
                                            {{ $notification->data['message'] }}
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-sm text-gray-400 text-center">
                                            <i data-lucide="bell-off" class="w-6 h-6 mx-auto mb-2 text-gray-300"></i>
                                            ยังไม่มีการแจ้งเตือน
                                        </div>
                                    @endforelse
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 pl-1 pr-3 py-1 rounded-full hover:bg-gray-100 transition">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-sm font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    <span class="flex items-center gap-2"><i data-lucide="user" class="w-4 h-4"></i> โปรไฟล์</span>
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <span class="flex items-center gap-2 text-danger-500"><i data-lucide="log-out" class="w-4 h-4"></i> ออกจากระบบ</span>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">เข้าสู่ระบบ</a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:shadow-lg hover:shadow-primary-500/30 transition-all">
                            สมัครสมาชิก
                        </a>
                    </div>
                @endauth

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="w-10 h-10 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100">
                        <i data-lucide="menu" x-show="!open" class="w-5 h-5"></i>
                        <i data-lucide="x" x-show="open" x-cloak class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 bg-white" x-cloak>
        <div class="px-4 pt-3 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-primary-50' : 'text-gray-600' }}">Dashboard</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('products.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600' }}">สินค้าประมูล</a>
            @auth
                <a href="{{ route('products.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-primary-600">+ ลงประมูล</a>
            @endauth
        </div>

        @auth
        <div class="px-4 py-3 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">โปรไฟล์</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 rounded-lg text-sm text-danger-500 hover:bg-red-50">ออกจากระบบ</a>
                </form>
            </div>
        </div>
        @else
        <div class="px-4 py-3 border-t border-gray-100 space-y-1">
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-600">เข้าสู่ระบบ</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm text-primary-600 font-medium">สมัครสมาชิก</a>
        </div>
        @endauth
    </div>
</nav>