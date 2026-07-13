<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900">Dashboard</h2>
        <p class="text-sm text-gray-500 mt-1">ภาพรวมสินค้าและการประมูลของคุณ</p>
    </x-slot>

    @php
        $activeSelling = $myProducts->where('status', 'active')->count();
        $totalSoldValue = $myProducts->where('status', 'ended')->whereNotNull('winner_id')->sum('current_price');
        $winningCount = $myBids->filter(fn($b) => $b->product->status === 'active' && $b->my_highest_bid >= $b->product->current_price)->count();
        $wonCount = $myBids->filter(fn($b) => $b->product->status === 'ended' && $b->product->winner_id === auth()->id())->count();
    @endphp

    <div class="py-10" x-data="{ tab: 'selling' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stat Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
                    <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center mb-3">
                        <i data-lucide="package" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $activeSelling }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">กำลังลงขาย</p>
                </div>
                <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
                    <div class="w-10 h-10 rounded-lg bg-accent-500/10 flex items-center justify-center mb-3">
                        <i data-lucide="trending-up" class="w-5 h-5 text-accent-500"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $winningCount }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">กำลังนำอยู่</p>
                </div>
                <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
                    <div class="w-10 h-10 rounded-lg bg-success-500/10 flex items-center justify-center mb-3">
                        <i data-lucide="trophy" class="w-5 h-5 text-success-500"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-900">{{ $wonCount }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">ชนะการประมูล</p>
                </div>
                <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
                    <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center mb-3">
                        <i data-lucide="wallet" class="w-5 h-5 text-primary-600"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-900">฿{{ number_format($totalSoldValue, 0) }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">ยอดขายรวม</p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-2 mb-5 bg-gray-100 p-1 rounded-full w-fit">
                <button @click="tab = 'selling'"
                        :class="tab === 'selling' ? 'bg-white shadow-soft text-primary-600' : 'text-gray-500'"
                        class="px-4 py-2 rounded-full font-medium text-sm transition-all">
                    สินค้าที่ฉันลงขาย
                </button>
                <button @click="tab = 'bidding'"
                        :class="tab === 'bidding' ? 'bg-white shadow-soft text-primary-600' : 'text-gray-500'"
                        class="px-4 py-2 rounded-full font-medium text-sm transition-all">
                    สินค้าที่ฉันประมูล
                </button>
            </div>

            <!-- Tab: สินค้าที่ลงขาย -->
            <div x-show="tab === 'selling'" class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 text-gray-400 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-3.5 font-semibold">สินค้า</th>
                            <th class="px-6 py-3.5 font-semibold">ราคาปัจจุบัน</th>
                            <th class="px-6 py-3.5 font-semibold">จำนวนบิด</th>
                            <th class="px-6 py-3.5 font-semibold">สถานะ</th>
                            <th class="px-6 py-3.5 font-semibold">ปิดประมูล</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($myProducts as $product)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="text-gray-800 hover:text-primary-600 font-semibold transition">
                                        {{ $product->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-700">฿{{ number_format($product->current_price, 2) }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $product->bids_count }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-success-500/10 text-success-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success-500"></span> กำลังประมูล
                                        </span>
                                    @elseif ($product->status === 'ended')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">ปิดแล้ว</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-accent-500/10 text-accent-500">{{ $product->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-400">{{ $product->ends_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <i data-lucide="package-x" class="w-10 h-10 mx-auto mb-3 text-gray-300"></i>
                                    <p class="text-gray-400 text-sm">คุณยังไม่เคยลงสินค้าประมูล</p>
                                    <a href="{{ route('products.create') }}" class="text-primary-600 hover:underline text-sm font-medium mt-1 inline-block">ลงสินค้าตอนนี้เลย</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tab: สินค้าที่ประมูล -->
            <div x-show="tab === 'bidding'" x-cloak class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 text-gray-400 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-3.5 font-semibold">สินค้า</th>
                            <th class="px-6 py-3.5 font-semibold">ราคาที่ฉันบิดสูงสุด</th>
                            <th class="px-6 py-3.5 font-semibold">ราคาปัจจุบัน</th>
                            <th class="px-6 py-3.5 font-semibold">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($myBids as $bid)
                            @php
                                $product = $bid->product;
                                $isWinning = $product->status === 'active' && $bid->my_highest_bid >= $product->current_price;
                                $isWinner = $product->status === 'ended' && $product->winner_id === auth()->id();
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $product) }}" class="text-gray-800 hover:text-primary-600 font-semibold transition">
                                        {{ $product->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-700">฿{{ number_format($bid->my_highest_bid, 2) }}</td>
                                <td class="px-6 py-4 text-gray-500">฿{{ number_format($product->current_price, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        @if ($isWinning)
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-success-500/10 text-success-500">กำลังนำ</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-danger-500/10 text-danger-500">ถูกแซงแล้ว</span>
                                        @endif
                                    @else
                                        @if ($isWinner)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-accent-500/10 text-accent-500">
                                                <i data-lucide="trophy" class="w-3 h-3"></i> ชนะ
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">แพ้</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <i data-lucide="gavel" class="w-10 h-10 mx-auto mb-3 text-gray-300"></i>
                                    <p class="text-gray-400 text-sm">คุณยังไม่เคยบิดสินค้า</p>
                                    <a href="{{ route('products.index') }}" class="text-primary-600 hover:underline text-sm font-medium mt-1 inline-block">ดูสินค้าประมูล</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>