<x-app-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-600 to-accent-500">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 text-white backdrop-blur mb-5">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> แพลตฟอร์มประมูลออนไลน์อันดับ 1
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                ประมูลสินค้าที่ใช่<br class="hidden sm:block"> ในราคาที่คุณกำหนดเอง
            </h1>
            <p class="text-white/80 mt-5 max-w-xl mx-auto">
                ซื้อ-ขายสินค้าผ่านระบบประมูลแบบเรียลไทม์ ปลอดภัย โปร่งใส เห็นราคาบิดล่าสุดทันทีไม่ต้องรีเฟรช
            </p>
            <div class="flex items-center justify-center gap-3 mt-8">
                <a href="{{ route('products.index') }}"
                   class="px-6 py-3 rounded-full text-sm font-bold text-primary-700 bg-white hover:shadow-xl transition-all flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i> ดูสินค้าประมูล
                </a>
                @guest
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 rounded-full text-sm font-bold text-white border border-white/30 hover:bg-white/10 transition-all">
                        สมัครสมาชิกฟรี
                    </a>
                @else
                    <a href="{{ route('products.create') }}"
                       class="px-6 py-3 rounded-full text-sm font-bold text-white border border-white/30 hover:bg-white/10 transition-all flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> ลงสินค้าประมูล
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['products'] }}</p>
                <p class="text-xs text-gray-500 mt-1">สินค้ากำลังประมูล</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['users'] }}</p>
                <p class="text-xs text-gray-500 mt-1">สมาชิกทั้งหมด</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['sold'] }}</p>
                <p class="text-xs text-gray-500 mt-1">ประมูลสำเร็จแล้ว</p>
            </div>
        </div>
    </section>

    <!-- Ending Soon -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                    <i data-lucide="flame" class="w-5 h-5 text-danger-500"></i> ใกล้หมดเวลา
                </h2>
                <p class="text-sm text-gray-500 mt-1">รีบบิดก่อนหมดเวลา!</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-primary-600 hover:underline flex items-center gap-1">
                ดูทั้งหมด <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($endingSoon as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="group bg-white rounded-xl2 shadow-soft hover:shadow-card border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-40 bg-gray-100 overflow-hidden">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-300">
                                <i data-lucide="image" class="w-8 h-8"></i>
                            </div>
                        @endif
                        <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-danger-500 text-white countdown"
                              data-ends-at="{{ $product->ends_at->toIso8601String() }}">--:--</span>
                    </div>
                    <div class="p-3.5">
                        <h3 class="font-bold text-sm text-gray-900 truncate group-hover:text-primary-600 transition">{{ $product->title }}</h3>
                        <p class="text-primary-600 font-extrabold mt-1">฿{{ number_format($product->current_price, 2) }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-400 py-10">ยังไม่มีสินค้าที่ใกล้หมดเวลา</p>
            @endforelse
        </div>
    </section>

    <!-- Recently Added -->
    <section class="bg-gray-50/70 py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                        <i data-lucide="sparkle" class="w-5 h-5 text-primary-600"></i> ลงล่าสุด
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">สินค้าใหม่ที่เพิ่งเปิดประมูล</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-primary-600 hover:underline flex items-center gap-1">
                    ดูทั้งหมด <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse ($recentlyAdded as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="group bg-white rounded-xl2 shadow-soft hover:shadow-card border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                        <div class="h-40 bg-gray-100 overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300">
                                    <i data-lucide="image" class="w-8 h-8"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-3.5">
                            <h3 class="font-bold text-sm text-gray-900 truncate group-hover:text-primary-600 transition">{{ $product->title }}</h3>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-primary-600 font-extrabold">฿{{ number_format($product->current_price, 2) }}</p>
                                <span class="text-xs text-gray-400 flex items-center gap-0.5"><i data-lucide="gavel" class="w-3 h-3"></i>{{ $product->bids_count }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-400 py-10">ยังไม่มีสินค้า</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-extrabold text-gray-900 text-center mb-10">ทำไมต้อง Auction Dee</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-primary-50 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="zap" class="w-6 h-6 text-primary-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1.5">เรียลไทม์ทันใจ</h3>
                <p class="text-sm text-gray-500">เห็นราคาบิดอัปเดตทันทีไม่ต้องรีเฟรชหน้า</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-accent-500/10 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield-check" class="w-6 h-6 text-accent-500"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1.5">ปลอดภัย โปร่งใส</h3>
                <p class="text-sm text-gray-500">ประวัติการบิดตรวจสอบได้ทุกขั้นตอน</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-success-500/10 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="gavel" class="w-6 h-6 text-success-500"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1.5">ลงขายง่าย</h3>
                <p class="text-sm text-gray-500">ลงสินค้าประมูลได้ภายในไม่กี่นาที</p>
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