<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900">สินค้าประมูลทั้งหมด</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} รายการที่กำลังประมูล</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="group bg-white rounded-xl2 shadow-soft hover:shadow-card border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">

                        <!-- รูปภาพ + Badge -->
                        <div class="relative h-52 bg-gray-100 overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300">
                                    <i data-lucide="image" class="w-10 h-10"></i>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur text-gray-700 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></span>
                                กำลังประมูล
                            </span>

                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-900/70 backdrop-blur text-white countdown"
                                  data-ends-at="{{ $product->ends_at->toIso8601String() }}">
                                --:--:--
                            </span>
                        </div>

                        <!-- เนื้อหาการ์ด -->
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 truncate group-hover:text-primary-600 transition">
                                {{ $product->title }}
                            </h3>

                            <div class="flex items-center gap-1.5 mt-1.5">
                                <div class="w-5 h-5 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-500">{{ $product->user->name }}</span>
                            </div>

                            <div class="flex items-end justify-between mt-3 pt-3 border-t border-gray-50">
                                <div>
                                    <p class="text-xs text-gray-400">ราคาปัจจุบัน</p>
                                    <p class="text-lg font-extrabold text-primary-600">
                                        ฿{{ number_format($product->current_price, 2) }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-gray-400">
                                    <i data-lucide="gavel" class="w-3.5 h-3.5"></i>
                                    {{ $product->bids_count }} บิด
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <i data-lucide="package-search" class="w-12 h-12 text-gray-300 mb-3"></i>
                        <p class="text-gray-500">ยังไม่มีสินค้าประมูล</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(el => {
                const endsAt = new Date(el.dataset.endsAt).getTime();
                const now = new Date().getTime();
                const diff = endsAt - now;

                if (diff <= 0) {
                    el.textContent = 'หมดเวลา';
                    return;
                }

                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                el.textContent = d > 0 ? `${d}ว ${h}ชม` : `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
            });
        }
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
    @endpush
</x-app-layout>