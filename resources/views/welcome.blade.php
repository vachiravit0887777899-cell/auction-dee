<x-app-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-vault-black">
        <div class="absolute inset-0 opacity-70" style="background: radial-gradient(ellipse at 50% 30%, rgba(207,174,69,0.10), transparent 60%), radial-gradient(ellipse at 20% 80%, rgba(207,174,69,0.06), transparent 50%);"></div>
        <div class="absolute inset-0 opacity-80" style="background-image: radial-gradient(1px 1px at 20% 30%, rgba(207,174,69,0.5), transparent), radial-gradient(1px 1px at 60% 70%, rgba(207,174,69,0.4), transparent), radial-gradient(1px 1px at 80% 20%, rgba(207,174,69,0.3), transparent), radial-gradient(1px 1px at 40% 85%, rgba(207,174,69,0.4), transparent), radial-gradient(1px 1px at 90% 60%, rgba(207,174,69,0.3), transparent);"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 text-center">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 border border-vault-border text-[11px] uppercase tracking-[3px] text-gold-soft mb-8">
                Hidden Vault · Est. legendary
            </span>
            <h1 class="font-serif font-semibold text-5xl sm:text-6xl lg:text-7xl leading-tight max-w-4xl mx-auto"
                style="background: linear-gradient(180deg, #fff 20%, #e8cf8a 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">
                Every Legend<br class="hidden sm:block"> Has A Price.
            </h1>
            <p class="text-ink-secondary mt-7 max-w-xl mx-auto text-[15px]">
                ค้นพบสมบัติภาพยนตร์หายากที่สุดในโลก ซ่อนอยู่ภายใน Auction Dee — ประมูลแบบเรียลไทม์ ปลอดภัย โปร่งใส
            </p>
            <div class="flex items-center justify-center gap-3 mt-10">
                <a href="{{ route('products.index') }}"
                   class="px-8 py-3.5 text-xs uppercase tracking-widest font-semibold text-vault-black bg-gradient-to-b from-gold-soft to-gold hover:shadow-gold transition-all rounded flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i> เข้าสู่ห้องนิรภัย
                </a>
                @guest
                    <a href="{{ route('register') }}"
                       class="px-8 py-3.5 text-xs uppercase tracking-widest text-ink-primary border border-vault-border hover:border-gold/50 transition-all rounded">
                        สมัครสมาชิกฟรี
                    </a>
                @else
                    <a href="{{ route('products.create') }}"
                       class="px-8 py-3.5 text-xs uppercase tracking-widest text-ink-primary border border-vault-border hover:border-gold/50 transition-all rounded">
                        ลงสินค้าประมูล
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="bg-vault-obsidian border-y border-vault-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-3 gap-6 text-center">
            <div>
                <p class="font-serif text-4xl font-semibold text-gold-soft">{{ $stats['products'] }}</p>
                <p class="text-[11px] uppercase tracking-widest text-ink-secondary mt-2">สมบัติในคลัง</p>
            </div>
            <div>
                <p class="font-serif text-4xl font-semibold text-gold-soft">{{ $stats['users'] }}</p>
                <p class="text-[11px] uppercase tracking-widest text-ink-secondary mt-2">สมาชิกทั้งหมด</p>
            </div>
            <div>
                <p class="font-serif text-4xl font-semibold text-gold-soft">{{ $stats['sold'] }}</p>
                <p class="text-[11px] uppercase tracking-widest text-ink-secondary mt-2">ประมูลสำเร็จ</p>
            </div>
        </div>
    </section>

    <!-- Ending Soon -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-8 pb-5 border-b border-vault-border">
            <div>
                <h2 class="font-serif text-3xl font-semibold text-gold-soft">ใกล้หมดเวลา</h2>
                <p class="text-xs uppercase tracking-widest text-ink-secondary mt-2">รีบประมูลก่อนหมดเวลา</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs uppercase tracking-widest text-gold-soft hover:text-gold-soft/70 flex items-center gap-1">
                ดูทั้งหมด <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($endingSoon as $product)
    @php $isUrgent = now()->diffInHours($product->ends_at, false) < 24; @endphp
    <a href="{{ route('products.show', $product) }}"
       class="vault-card group bg-gradient-to-b from-vault-stone to-vault-obsidian border border-vault-border hover:border-gold/40 rounded overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-gold {{ $isUrgent ? 'ending-soon-glow' : '' }}">
                    <div class="relative h-40 bg-vault-obsidian overflow-hidden">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-ink-secondary/30">
                                <i data-lucide="gem" class="w-8 h-8"></i>
                            </div>
                        @endif
                        <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] uppercase tracking-wide bg-vault-black/80 text-gold-soft border border-gold/30 rounded countdown"
                              data-ends-at="{{ $product->ends_at->toIso8601String() }}">--:--</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-serif text-base font-semibold text-ink-primary truncate group-hover:text-gold-soft transition">{{ $product->title }}</h3>
                        <p class="font-serif text-lg text-gold-soft mt-1">฿{{ number_format($product->current_price, 2) }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-ink-secondary py-10">ยังไม่มีสินค้าที่ใกล้หมดเวลา</p>
            @endforelse
        </div>
    </section>

    <!-- Recently Added -->
    <section class="bg-vault-obsidian py-20 border-y border-vault-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8 pb-5 border-b border-vault-border">
                <div>
                    <h2 class="font-serif text-3xl font-semibold text-gold-soft">Hall of Legends</h2>
                    <p class="text-xs uppercase tracking-widest text-ink-secondary mt-2">คัดสรรล่าสุดโดยภัณฑารักษ์</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs uppercase tracking-widest text-gold-soft hover:text-gold-soft/70 flex items-center gap-1">
                    ดูทั้งหมด <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($recentlyAdded as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="group bg-gradient-to-b from-vault-stone to-vault-black border border-vault-border hover:border-gold/40 rounded overflow-hidden transition-all duration-300 hover:-translate-y-1">
                        <div class="h-40 bg-vault-black overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-ink-secondary/30">
                                    <i data-lucide="gem" class="w-8 h-8"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-serif text-base font-semibold text-ink-primary truncate group-hover:text-gold-soft transition">{{ $product->title }}</h3>
                            <div class="flex items-center justify-between mt-1">
                                <p class="font-serif text-lg text-gold-soft">฿{{ number_format($product->current_price, 2) }}</p>
                                <span class="text-[11px] text-ink-secondary flex items-center gap-1"><i data-lucide="gavel" class="w-3 h-3"></i>{{ $product->bids_count }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-ink-secondary py-10">ยังไม่มีสินค้า</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <h2 class="font-serif text-3xl font-semibold text-gold-soft text-center mb-14">ทำไมต้อง Auction Dee</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
            <div class="text-center">
                <div class="w-14 h-14 border border-gold/30 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="zap" class="w-6 h-6 text-gold-soft"></i>
                </div>
                <h3 class="font-serif text-lg font-semibold text-ink-primary mb-2">เรียลไทม์ทันใจ</h3>
                <p class="text-sm text-ink-secondary">เห็นราคาบิดอัปเดตทันทีไม่ต้องรีเฟรชหน้า</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 border border-gold/30 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="shield-check" class="w-6 h-6 text-gold-soft"></i>
                </div>
                <h3 class="font-serif text-lg font-semibold text-ink-primary mb-2">ปลอดภัย โปร่งใส</h3>
                <p class="text-sm text-ink-secondary">ประวัติการบิดตรวจสอบได้ทุกขั้นตอน</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 border border-gold/30 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="gem" class="w-6 h-6 text-gold-soft"></i>
                </div>
                <h3 class="font-serif text-lg font-semibold text-ink-primary mb-2">สมบัติแท้เท่านั้น</h3>
                <p class="text-sm text-ink-secondary">ทุกชิ้นถูกคัดสรรและตรวจสอบก่อนขึ้นประมูล</p>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(el => {
                const diff = new Date(el.dataset.endsAt).getTime() - new Date().getTime();
                if (diff <= 0) { el.textContent = 'หมดเวลา'; return; }
                const h = Math.floor(diff / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                el.textContent = `${h}:${String(m).padStart(2,'0')}`;
            });
        }
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
    @endpush
</x-app-layout>