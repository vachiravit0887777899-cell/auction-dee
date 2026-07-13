<x-app-layout>
    <x-slot name="header">
        <nav class="text-sm text-gray-400 mb-1">
            <a href="{{ route('products.index') }}" class="hover:text-primary-600">สินค้าประมูล</a>
            <span class="mx-1">/</span>
            <span class="text-gray-600">{{ Str::limit($product->title, 40) }}</span>
        </nav>
        <h2 class="font-extrabold text-2xl text-gray-900">{{ $product->title }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-success-500/10 text-success-500 border border-success-500/20 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

                <!-- ฝั่งซ้าย: รูปภาพ + รายละเอียด -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
                        <div class="h-96 bg-gray-100 flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover">
                            @else
                                <i data-lucide="image" class="w-12 h-12 text-gray-300"></i>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <i data-lucide="align-left" class="w-4 h-4 text-gray-400"></i>
                            รายละเอียดสินค้า
                        </h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>

                        <div class="flex items-center gap-2 mt-5 pt-5 border-t border-gray-50">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr($product->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">ผู้ลงประมูล</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $product->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- ประวัติการบิด -->
                    <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4 text-gray-400"></i>
                            ประวัติการบิดล่าสุด
                        </h3>
                        <ul id="bid-history" class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse ($product->bids as $bid)
                                <li class="flex items-center justify-between text-sm pb-3 border-b border-gray-50 last:border-0">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs font-bold">
                                            {{ strtoupper(substr($bid->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700">{{ $bid->user->name }}</span>
                                    </div>
                                    <span class="font-bold text-gray-900">฿{{ number_format($bid->amount, 2) }}</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-sm text-center py-6">
                                    <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-2 text-gray-300"></i>
                                    ยังไม่มีการบิด
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- ฝั่งขวา: Sticky Bid Panel -->
                <div class="lg:col-span-2">
                    <div class="sticky top-24 bg-white rounded-xl2 shadow-card border border-gray-100 p-6">

                        @if ($product->status === 'ended')
                            <!-- สถานะปิดแล้ว -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 mb-3">
                                <i data-lucide="lock" class="w-3 h-3"></i> ปิดประมูลแล้ว
                            </span>
                            <p class="text-xs text-gray-400">ราคาปิดประมูล</p>
                            <p class="text-4xl font-extrabold text-gray-800 mt-1">
                                ฿{{ number_format($product->current_price, 2) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2">ปิดเมื่อ {{ $product->ends_at->format('d/m/Y H:i') }}</p>

                            <div class="mt-5 pt-5 border-t border-gray-100">
                                @if ($product->winner_id)
                                    <div class="flex items-center gap-2 bg-accent-500/10 text-accent-500 px-4 py-3 rounded-xl">
                                        <i data-lucide="trophy" class="w-5 h-5"></i>
                                        <span class="text-sm font-semibold">ผู้ชนะ: {{ $product->winner->name }}</span>
                                    </div>
                                    @if (auth()->id() === $product->winner_id)
                                        <p class="text-sm text-success-500 mt-3 font-semibold flex items-center gap-1.5">
                                            <i data-lucide="party-popper" class="w-4 h-4"></i> ยินดีด้วย! คุณชนะการประมูลนี้
                                        </p>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-400">ไม่มีผู้เข้าร่วมประมูล</p>
                                @endif
                            </div>

                        @else
                            <!-- สถานะกำลังประมูล -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-success-500/10 text-success-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></span>
                                    กำลังประมูล
                                </span>
                                <span class="text-xs font-semibold text-danger-500 flex items-center gap-1 detail-countdown"
                                      data-ends-at="{{ $product->ends_at->toIso8601String() }}">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> --:--:--
                                </span>
                            </div>

                            <p class="text-xs text-gray-400">ราคาปัจจุบัน</p>
                            <p id="current-price" class="text-4xl font-extrabold text-primary-600 mt-1">
                                ฿{{ number_format($product->current_price, 2) }}
                            </p>

                            <div id="new-bid-alert" class="hidden mt-3 bg-accent-500/10 text-accent-500 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-1.5">
                                <i data-lucide="zap" class="w-3.5 h-3.5"></i> มีคนบิดราคาสูงกว่าคุณแล้ว!
                            </div>

                            <div class="mt-5 pt-5 border-t border-gray-100">
                                @auth
                                    @if ($product->user_id !== auth()->id())
                                        <form method="POST" action="{{ route('products.bid', $product) }}">
                                            @csrf
                                            <label class="block text-xs font-medium text-gray-500 mb-2">
                                                บิดขั้นต่ำ: <span id="minimum-bid" class="text-gray-700 font-semibold">฿{{ number_format($product->current_price + $product->bid_increment, 2) }}</span>
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">฿</span>
                                                <input type="number" step="0.01" name="amount" id="amount-input"
                                                       value="{{ old('amount', $product->current_price + $product->bid_increment) }}"
                                                       class="w-full pl-7 pr-3 py-3 rounded-xl border-gray-200 focus:border-primary-500 focus:ring-primary-500 text-sm font-semibold">
                                            </div>
                                            @error('amount')
                                                <p class="text-danger-500 text-xs mt-1.5">{{ $message }}</p>
                                            @enderror
                                            <button type="submit"
                                                    class="w-full mt-3 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center justify-center gap-2">
                                                <i data-lucide="gavel" class="w-4 h-4"></i> บิดเลย
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-sm text-gray-400 text-center py-2">นี่คือสินค้าของคุณเอง ไม่สามารถบิดได้</p>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full py-3 rounded-xl text-sm font-bold text-center text-white bg-gradient-to-r from-primary-600 to-primary-500">
                                        เข้าสู่ระบบเพื่อร่วมประมูล
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productId = {{ $product->id }};
            const bidIncrement = {{ $product->bid_increment }};

            // Countdown ในหน้ารายละเอียด
            function updateDetailCountdown() {
                const el = document.querySelector('.detail-countdown');
                if (!el) return;
                const endsAt = new Date(el.dataset.endsAt).getTime();
                const diff = endsAt - new Date().getTime();

                if (diff <= 0) {
                    el.innerHTML = '<i data-lucide="clock" class="w-3.5 h-3.5"></i> หมดเวลา';
                    return;
                }
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);
                const text = d > 0 ? `${d}ว ${h}ชม ${m}น` : `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
                el.innerHTML = `<i data-lucide="clock" class="w-3.5 h-3.5"></i> ${text}`;
            }
            updateDetailCountdown();
            setInterval(updateDetailCountdown, 1000);

            // Real-time bidding ผ่าน WebSocket
            if (window.Echo) {
                window.Echo.channel('product.' + productId)
                    .listen('.NewBidPlaced', (e) => {
                        document.getElementById('current-price').textContent = '฿' + e.amount;

                        const minimumBidEl = document.getElementById('minimum-bid');
                        const amountInput = document.getElementById('amount-input');
                        if (minimumBidEl && amountInput) {
                            const newMinimum = parseFloat(e.raw_amount) + bidIncrement;
                            minimumBidEl.textContent = '฿' + newMinimum.toLocaleString('en-US', { minimumFractionDigits: 2 });
                            amountInput.value = newMinimum.toFixed(2);
                        }

                        const bidHistory = document.getElementById('bid-history');
                        if (bidHistory.children.length === 1 && bidHistory.textContent.includes('ยังไม่มีการบิด')) {
                            bidHistory.innerHTML = '';
                        }
                        const li = document.createElement('li');
                        li.className = 'flex items-center justify-between text-sm pb-3 border-b border-gray-50';
                        li.innerHTML = `
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-accent-500/20 flex items-center justify-center text-accent-500 text-xs font-bold">${e.bidder_name.charAt(0).toUpperCase()}</div>
                                <span class="text-gray-700">${e.bidder_name}</span>
                            </div>
                            <span class="font-bold text-gray-900">฿${e.amount}</span>`;
                        bidHistory.prepend(li);

                        const alertBox = document.getElementById('new-bid-alert');
                        if (alertBox) {
                            alertBox.classList.remove('hidden');
                            setTimeout(() => alertBox.classList.add('hidden'), 4000);
                        }

                        if (window.lucide) lucide.createIcons();
                    });
            }
        });
    </script>
    @endpush
</x-app-layout>