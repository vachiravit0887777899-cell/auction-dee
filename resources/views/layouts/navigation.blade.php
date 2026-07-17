<nav x-data="{ open: false }" class="bg-vault-black/70 backdrop-blur-md border-b border-vault-border sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 rounded border border-gold/40 flex items-center justify-center">
                        <i data-lucide="gem" class="w-4 h-4 text-gold-soft"></i>
                    </div>
                    <span class="font-serif font-bold text-lg text-gold-soft tracking-wide hidden sm:block">Auction Dee</span>
                </a>

                <div class="hidden space-x-1 sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="relative px-3 py-2 text-xs uppercase tracking-widest transition {{ request()->routeIs('dashboard') ? 'text-gold-soft' : 'text-ink-secondary hover:text-gold-soft' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="relative px-3 py-2 text-xs uppercase tracking-widest transition {{ request()->routeIs('products.*') ? 'text-gold-soft' : 'text-ink-secondary hover:text-gold-soft' }}">
                        คลังสมบัติ
                    </a>
                    @auth
                    @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                       class="relative px-3 py-2 text-xs uppercase tracking-widest transition {{ request()->routeIs('admin.*') ? 'text-gold-soft' : 'text-ink-secondary hover:text-gold-soft' }}">
                        Admin
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('products.create') }}"
                       class="hidden sm:flex items-center gap-1.5 px-4 py-2 text-xs uppercase tracking-widest font-semibold text-vault-black bg-gradient-to-b from-gold-soft to-gold hover:shadow-gold transition-all duration-200 rounded">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        ลงประมูล
                    </a>

                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="80">
                            <x-slot name="trigger">
                                <button class="relative w-10 h-10 flex items-center justify-center rounded-full text-ink-secondary hover:text-gold-soft transition">
                                    <i data-lucide="bell" class="w-5 h-5"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-gold rounded-full ring-2 ring-vault-black"></span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-vault-border bg-vault-obsidian">
                                    <p class="text-xs uppercase tracking-widest text-gold-soft font-semibold">การแจ้งเตือน</p>
                                </div>
                                <div class="max-h-96 overflow-y-auto bg-vault-obsidian">
                                    @forelse (auth()->user()->notifications()->latest()->limit(10)->get() as $notification)
                                        <div class="px-4 py-3 text-sm border-b border-vault-border {{ $notification->read_at ? 'text-ink-secondary' : 'text-ink-primary bg-gold/5' }}">
                                            {{ $notification->data['message'] }}
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-sm text-ink-secondary text-center">
                                            <i data-lucide="bell-off" class="w-6 h-6 mx-auto mb-2 opacity-40"></i>
                                            ยังไม่มีการแจ้งเตือน
                                        </div>
                                    @endforelse
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 pl-1 pr-3 py-1 rounded-full hover:bg-vault-stone transition">
                                    <div class="w-8 h-8 rounded-full border border-gold/40 flex items-center justify-center text-gold-soft text-sm font-serif font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="text-xs uppercase tracking-widest text-ink-secondary">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-ink-secondary"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-vault-obsidian">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        <span class="flex items-center gap-2 text-ink-primary"><i data-lucide="user" class="w-4 h-4"></i> โปรไฟล์</span>
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                            <span class="flex items-center gap-2 text-red-400"><i data-lucide="log-out" class="w-4 h-4"></i> ออกจากระบบ</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-xs uppercase tracking-widest text-ink-secondary hover:text-gold-soft">เข้าสู่ระบบ</a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-xs uppercase tracking-widest font-semibold text-vault-black bg-gradient-to-b from-gold-soft to-gold hover:shadow-gold transition-all rounded">
                            สมัครสมาชิก
                        </a>
                    </div>
                @endauth

                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="w-10 h-10 flex items-center justify-center rounded-full text-ink-secondary hover:text-gold-soft">
                        <i data-lucide="menu" x-show="!open" class="w-5 h-5"></i>
                        <i data-lucide="x" x-show="open" x-cloak class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-vault-border bg-vault-obsidian" x-cloak>
        <div class="px-4 pt-3 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-xs uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'text-gold-soft' : 'text-ink-secondary' }}">Dashboard</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 text-xs uppercase tracking-widest {{ request()->routeIs('products.*') ? 'text-gold-soft' : 'text-ink-secondary' }}">คลังสมบัติ</a>
            @auth
                <a href="{{ route('products.create') }}" class="block px-3 py-2 text-xs uppercase tracking-widest text-gold-soft">+ ลงประมูล</a>
                @if (auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-xs uppercase tracking-widest text-ink-secondary">Admin</a>
                @endif
            @endauth
        </div>

        @auth
        <div class="px-4 py-3 border-t border-vault-border">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full border border-gold/40 flex items-center justify-center text-gold-soft text-sm font-serif font-semibold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-primary">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-ink-secondary">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-ink-secondary">โปรไฟล์</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 text-sm text-red-400">ออกจากระบบ</a>
                </form>
            </div>
        </div>
        @else
        <div class="px-4 py-3 border-t border-vault-border space-y-1">
            <a href="{{ route('login') }}" class="block px-3 py-2 text-sm text-ink-secondary">เข้าสู่ระบบ</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 text-sm text-gold-soft font-medium">สมัครสมาชิก</a>
        </div>
        @endauth
    </div>
</nav>