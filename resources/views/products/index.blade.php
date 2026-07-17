<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-semibold text-gold-soft">คลังสมบัติทั้งหมด</h2>
        <p class="text-xs uppercase tracking-widest text-ink-secondary mt-1">{{ $products->total() }} รายการที่กำลังประมูล</p>
    </x-slot>

    <div class="py-14">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}"
   class="vault-card group bg-gradient-to-b from-vault-stone to-vault-obsidian border border-vault-border hover:border-gold/40 rounded overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-gold">

                        <div class="relative h-52 bg-vault-black overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-ink-secondary/30">
                                    <i data-lucide="gem" class="w-10 h-10"></i>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-black/80 text-gold-soft border border-gold/30 rounded flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-gold-soft animate-pulse"></span> กำลังประมูล
                            </span>

                            <span class="absolute top-3 right-3 px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-black/80 text-ink-primary border border-vault-border rounded countdown"
                                  data-ends-at="{{ $product->ends_at->toIso8601String() }}">--:--:--</span>
                        </div>

                        <div class="p-5">
                            <h3 class="font-serif text-lg font-semibold text-ink-primary truncate group-hover:text-gold-soft transition">
                                {{ $product->title }}
                            </h3>

                            <div class="flex items-center gap-1.5 mt-2">
                                <div class="w-5 h-5 rounded-full border border-gold/30 flex items-center justify-center text-gold-soft text-[9px] font-serif font-semibold">
                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                </div>
                                <span class="text-xs text-ink-secondary">{{ $product->user->name }}</span>
                            </div>

                            <div class="flex items-end justify-between mt-4 pt-4 border-t border-vault-border">
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-ink-secondary">ราคาปัจจุบัน</p>
                                    <p class="font-serif text-xl font-semibold text-gold-soft">
                                        ฿{{ number_format($product->current_price, 2) }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-ink-secondary">
                                    <i data-lucide="gavel" class="w-3.5 h-3.5"></i>
                                    {{ $product->bids_count }} บิด
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <i data-lucide="gem" class="w-12 h-12 text-ink-secondary/30 mb-4"></i>
                        <p class="text-ink-secondary">ยังไม่มีสินค้าประมูล</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(el => {
                const endsAt = new Date(el.dataset.endsAt).getTime();
                const diff = endsAt - new Date().getTime();
                if (diff <= 0) { el.textContent = 'หมดเวลา'; return; }
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