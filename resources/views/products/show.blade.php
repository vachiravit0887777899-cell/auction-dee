<x-app-layout>
    <x-slot name="header">
        <nav class="text-xs text-ink-secondary mb-2 uppercase tracking-widest">
            <a href="{{ route('products.index') }}" class="hover:text-gold-soft">คลังสมบัติ</a>
            <span class="mx-1">/</span>
            <span class="text-gold-soft">{{ Str::limit($product->title, 40) }}</span>
        </nav>
        <h2 class="font-serif text-2xl font-semibold text-ink-primary">{{ $product->title }}</h2>
    </x-slot>

    <div class="py-14">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-gold/10 text-gold-soft border border-gold/30 px-4 py-3 rounded mb-6 text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-vault-obsidian border border-vault-border rounded overflow-hidden">
                        <div class="h-96 bg-vault-black flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover opacity-95">
                            @else
                                <i data-lucide="gem" class="w-14 h-14 text-ink-secondary/30"></i>
                            @endif
                        </div>
                    </div>

                    <div class="bg-vault-obsidian border border-vault-border rounded p-6">
                        <h3 class="font-serif text-lg font-semibold text-gold-soft mb-3 flex items-center gap-2">
                            <i data-lucide="align-left" class="w-4 h-4"></i>
                            รายละเอียดสมบัติ
                        </h3>
                        <p class="text-sm text-ink-secondary leading-relaxed">{{ $product->description }}</p>

                        <div class="flex items-center gap-2 mt-5 pt-5 border-t border-vault-border">
                            <div class="w-9 h-9 rounded-full border border-gold/30 flex items-center justify-center text-gold-soft text-sm font-serif font-semibold">
                                {{ strtoupper(substr($product->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-ink-secondary">ผู้ลงประมูล</p>
                                <p class="text-sm font-medium text-ink-primary">{{ $product->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-vault-obsidian border border-vault-border rounded p-6">
                        <h3 class="font-serif text-lg font-semibold text-gold-soft mb-4 flex items-center gap-2">
                            <i data-lucide="history" class="w-4 h-4"></i>
                            ประวัติการบิดล่าสุด
                        </h3>
                        <ul id="bid-history" class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse ($product->bids as $bid)
                                <li class="flex items-center justify-between text-sm pb-3 border-b border-vault-border last:border-0">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full border border-vault-border flex items-center justify-center text-ink-secondary text-xs font-serif font-semibold">
                                            {{ strtoupper(substr($bid->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-ink-primary">{{ $bid->user->name }}</span>
                                    </div>
                                    <span class="font-serif font-semibold text-gold-soft">฿{{ number_format($bid->amount, 2) }}</span>
                                </li>
                            @empty
                                <li class="text-ink-secondary text-sm text-center py-6">
                                    <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-2 opacity-30"></i>
                                    ยังไม่มีการบิด
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="sticky top-24 bg-vault-obsidian border border-gold/20 rounded p-6">

                        @if ($product->status === 'ended')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] uppercase tracking-widest bg-vault-stone text-ink-secondary border border-vault-border rounded mb-3">
                                <i data-lucide="lock" class="w-3 h-3"></i> ปิดประมูลแล้ว
                            </span>
                            <p class="text-[10px] uppercase tracking-widest text-ink-secondary">ราคาปิดประมูล</p>
                            <p class="font-serif text-4xl font-semibold text-ink-primary mt-1">
                                ฿{{ number_format($product->current_price, 2) }}
                            </p>
                            <p class="text-xs text-ink-secondary mt-2">ปิดเมื่อ {{ $product->ends_at->format('d/m/Y H:i') }}</p>

                            <div class="mt-5 pt-5 border-t border-vault-border">
                                @if ($product->winner_id)
                                    <div class="flex items-center gap-2 bg-gold/10 text-gold-soft border border-gold/30 px-4 py-3 rounded">
                                        <i data-lucide="trophy" class="w-5 h-5"></i>
                                        <span class="text-sm font-semibold">ผู้ชนะ: {{ $product->winner->name }}</span>
                                    </div>
                                    @if (auth()->id() === $product->winner_id)
                                        <p class="text-sm text-gold-soft mt-3 font-semibold flex items-center gap-1.5">
                                            <i data-lucide="party-popper" class="w-4 h-4"></i> ยินดีด้วย! คุณคือผู้ครอบครองสมบัตินี้
                                        </p>
                                    @endif
                                @else
                                    <p class="text-sm text-ink-secondary">ไม่มีผู้เข้าร่วมประมูล</p>
                                @endif
                            </div>

                        @else
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] uppercase tracking-widest bg-gold/10 text-gold-soft border border-gold/30 rounded">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold-soft animate-pulse"></span>
                                    กำลังประมูล
                                </span>
                                <span class="text-xs font-medium text-ink-primary flex items-center gap-1 detail-countdown"
                                      data-ends-at="{{ $product->ends_at->toIso8601String() }}">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> --:--:--
                                </span>
                            </div>

                            <p class="text-[10px] uppercase tracking-widest text-ink-secondary">ราคาปัจจุบัน</p>
                            <p id="current-price" class="font-serif text-4xl font-semibold text-gold-soft mt-1">
                                ฿{{ number_format($product->current_price, 2) }}
                            </p>

                            <div id="new-bid-alert" class="hidden mt-3 bg-gold/10 text-gold-soft border border-gold/20 px-3 py-2 rounded text-xs font-medium flex items-center gap-1.5">
                                <i data-lucide="zap" class="w-3.5 h-3.5"></i> มีคนบิดราคาสูงกว่าคุณแล้ว!
                            </div>

                            <div class="mt-5 pt-5 border-t border-vault-border">
                                @auth
                                    @if ($product->user_id !== auth()->id())
                                        <form method="POST" action="{{ route('products.bid', $product) }}">
                                            @csrf
                                            <label class="block text-[10px] uppercase tracking-widest text-ink-secondary mb-2">
                                                บิดขั้นต่ำ: <span id="minimum-bid" class="text-gold-soft font-semibold">฿{{ number_format($product->current_price + $product->bid_increment, 2) }}</span>
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-ink-secondary text-sm">฿</span>
                                                <input type="number" step="0.01" name="amount" id="amount-input"
                                                       value="{{ old('amount', $product->current_price + $product->bid_increment) }}"
                                                       class="w-full pl-7 pr-3 py-3 bg-vault-black border-vault-border focus:border-gold focus:ring-gold text-sm font-semibold text-ink-primary rounded">
                                            </div>
                                            @error('amount')
                                                <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                                            @enderror
                                            <button type="submit"
                                                    class="w-full mt-3 py-3 text-xs uppercase tracking-widest font-semibold text-vault-black bg-gradient-to-b from-gold-soft to-gold hover:shadow-gold transition-all rounded flex items-center justify-center gap-2">
                                                <i data-lucide="gavel" class="w-4 h-4"></i> บิดเลย
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-sm text-ink-secondary text-center py-2">นี่คือสมบัติของคุณเอง ไม่สามารถบิดได้</p>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full py-3 text-xs uppercase tracking-widest font-semibold text-center text-vault-black bg-gradient-to-b from-gold-soft to-gold rounded">
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

            function updateDetailCountdown() {
                const el = document.querySelector('.detail-countdown');
                if (!el) return;
                const diff = new Date(el.dataset.endsAt).getTime() - new Date().getTime();
                if (diff <= 0) { el.innerHTML = '<i data-lucide="clock" class="w-3.5 h-3.5"></i> หมดเวลา'; return; }
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);
                const text = d > 0 ? `${d}ว ${h}ชม ${m}น` : `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
                el.innerHTML = `<i data-lucide="clock" class="w-3.5 h-3.5"></i> ${text}`;
            }
            updateDetailCountdown();
            setInterval(updateDetailCountdown, 1000);

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
                        li.className = 'flex items-center justify-between text-sm pb-3 border-b border-vault-border';
                        li.innerHTML = `
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full border border-gold/40 flex items-center justify-center text-gold-soft text-xs font-serif font-semibold">${e.bidder_name.charAt(0).toUpperCase()}</div>
                                <span class="text-ink-primary">${e.bidder_name}</span>
                            </div>
                            <span class="font-serif font-semibold text-gold-soft">฿${e.amount}</span>`;
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