<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-semibold text-gold-soft">Dashboard</h2>
        <p class="text-xs uppercase tracking-widest text-ink-secondary mt-1">ภาพรวมสมบัติและการประมูลของคุณ</p>
    </x-slot>

    @php
        $activeSelling = $myProducts->where('status', 'active')->count();
        $totalSoldValue = $myProducts->where('status', 'ended')->whereNotNull('winner_id')->sum('current_price');
        $winningCount = $myBids->filter(fn($b) => $b->product->status === 'active' && $b->my_highest_bid >= $b->product->current_price)->count();
        $wonCount = $myBids->filter(fn($b) => $b->product->status === 'ended' && $b->product->winner_id === auth()->id())->count();
    @endphp

    <div class="py-14" x-data="{ tab: 'selling' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                <div class="bg-vault-obsidian border border-vault-border rounded p-5">
                    <div class="w-10 h-10 border border-gold/30 rounded flex items-center justify-center mb-3">
                        <i data-lucide="package" class="w-5 h-5 text-gold-soft"></i>
                    </div>
                    <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $activeSelling }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">กำลังลงขาย</p>
                </div>
                <div class="bg-vault-obsidian border border-vault-border rounded p-5">
                    <div class="w-10 h-10 border border-gold/30 rounded flex items-center justify-center mb-3">
                        <i data-lucide="trending-up" class="w-5 h-5 text-gold-soft"></i>
                    </div>
                    <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $winningCount }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">กำลังนำอยู่</p>
                </div>
                <div class="bg-vault-obsidian border border-vault-border rounded p-5">
                    <div class="w-10 h-10 border border-gold/30 rounded flex items-center justify-center mb-3">
                        <i data-lucide="trophy" class="w-5 h-5 text-gold-soft"></i>
                    </div>
                    <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $wonCount }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">ชนะการประมูล</p>
                </div>
                <div class="bg-vault-obsidian border border-vault-border rounded p-5">
                    <div class="w-10 h-10 border border-gold/30 rounded flex items-center justify-center mb-3">
                        <i data-lucide="wallet" class="w-5 h-5 text-gold-soft"></i>
                    </div>
                    <p class="font-serif text-2xl font-semibold text-gold-soft">฿{{ number_format($totalSoldValue, 0) }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">ยอดขายรวม</p>
                </div>
            </div>

            <div class="flex gap-1 mb-6 border-b border-vault-border w-fit">
                <button @click="tab = 'selling'"
                        :class="tab === 'selling' ? 'text-gold-soft border-gold-soft' : 'text-ink-secondary border-transparent'"
                        class="px-5 py-2.5 text-xs uppercase tracking-widest border-b-2 transition-all">
                    สินค้าที่ฉันลงขาย
                </button>
                <button @click="tab = 'bidding'"
                        :class="tab === 'bidding' ? 'text-gold-soft border-gold-soft' : 'text-ink-secondary border-transparent'"
                        class="px-5 py-2.5 text-xs uppercase tracking-widest border-b-2 transition-all">
                    สินค้าที่ฉันประมูล
                </button>
            </div>

            <div x-show="tab === 'selling'" class="bg-vault-obsidian border border-vault-border rounded overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-vault-black text-ink-secondary uppercase text-[10px] tracking-widest">
                        <tr>
                            <th class="px-6 py-3.5 font-medium">สินค้า</th>
                            <th class="px-6 py-3.5 font-medium">ราคาปัจจุบัน</th>
                            <th class="px-6 py-3.5 font-medium">จำนวนบิด</th>
                            <th class="px-6 py-3.5 font-medium">สถานะ</th>
                            <th class="px-6 py-3.5 font-medium">ปิดประมูล</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-border">
                        @forelse ($myProducts as $product)
                            <tr class="hover:bg-vault-stone/50 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="text-ink-primary hover:text-gold-soft font-medium transition">
                                        {{ $product->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-serif font-semibold text-gold-soft">฿{{ number_format($product->current_price, 2) }}</td>
                                <td class="px-6 py-4 text-ink-secondary">{{ $product->bids_count }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] uppercase tracking-wide bg-gold/10 text-gold-soft border border-gold/30 rounded">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gold-soft"></span> กำลังประมูล
                                        </span>
                                    @elseif ($product->status === 'ended')
                                        <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-stone text-ink-secondary border border-vault-border rounded">ปิดแล้ว</span>
                                    @else
                                        <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-stone text-ink-secondary border border-vault-border rounded">{{ $product->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-ink-secondary">{{ $product->ends_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <i data-lucide="package-x" class="w-10 h-10 mx-auto mb-3 text-ink-secondary/30"></i>
                                    <p class="text-ink-secondary text-sm">คุณยังไม่เคยลงสินค้าประมูล</p>
                                    <a href="{{ route('products.create') }}" class="text-gold-soft hover:underline text-sm font-medium mt-1 inline-block">ลงสินค้าตอนนี้เลย</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'bidding'" x-cloak class="bg-vault-obsidian border border-vault-border rounded overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-vault-black text-ink-secondary uppercase text-[10px] tracking-widest">
                        <tr>
                            <th class="px-6 py-3.5 font-medium">สินค้า</th>
                            <th class="px-6 py-3.5 font-medium">ราคาที่ฉันบิดสูงสุด</th>
                            <th class="px-6 py-3.5 font-medium">ราคาปัจจุบัน</th>
                            <th class="px-6 py-3.5 font-medium">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-border">
                        @forelse ($myBids as $bid)
                            @php
                                $product = $bid->product;
                                $isWinning = $product->status === 'active' && $bid->my_highest_bid >= $product->current_price;
                                $isWinner = $product->status === 'ended' && $product->winner_id === auth()->id();
                            @endphp
                            <tr class="hover:bg-vault-stone/50 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="text-ink-primary hover:text-gold-soft font-medium transition">
                                        {{ $product->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-serif font-semibold text-gold-soft">฿{{ number_format($bid->my_highest_bid, 2) }}</td>
                                <td class="px-6 py-4 text-ink-secondary">฿{{ number_format($product->current_price, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        @if ($isWinning)
                                            <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-gold/10 text-gold-soft border border-gold/30 rounded">กำลังนำ</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-red-500/10 text-red-400 border border-red-500/20 rounded">ถูกแซงแล้ว</span>
                                        @endif
                                    @else
                                        @if ($isWinner)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] uppercase tracking-wide bg-gold/10 text-gold-soft border border-gold/30 rounded">
                                                <i data-lucide="trophy" class="w-3 h-3"></i> ชนะ
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-stone text-ink-secondary border border-vault-border rounded">แพ้</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <i data-lucide="gavel" class="w-10 h-10 mx-auto mb-3 text-ink-secondary/30"></i>
                                    <p class="text-ink-secondary text-sm">คุณยังไม่เคยบิดสินค้า</p>
                                    <a href="{{ route('products.index') }}" class="text-gold-soft hover:underline text-sm font-medium mt-1 inline-block">ดูสินค้าประมูล</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>