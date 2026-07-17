<x-admin.layout>
    <h1 class="font-serif text-2xl font-semibold text-gold-soft mb-8">ภาพรวมระบบ</h1>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $stats['total_users'] }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">ผู้ใช้ทั้งหมด</p>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $stats['total_products'] }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">สินค้าทั้งหมด</p>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-gold-soft">{{ $stats['active_products'] }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">กำลังประมูล</p>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-ink-secondary">{{ $stats['ended_products'] }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">ปิดแล้ว</p>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-ink-primary">{{ $stats['total_bids'] }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">จำนวนบิดทั้งหมด</p>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <p class="font-serif text-2xl font-semibold text-gold-soft">฿{{ number_format($stats['total_sold_value'], 0) }}</p>
            <p class="text-[10px] uppercase tracking-widest text-ink-secondary mt-1">มูลค่าขายสำเร็จรวม</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <h3 class="font-serif font-semibold text-gold-soft mb-3">สินค้าล่าสุด</h3>
            <div class="space-y-3">
                @foreach ($recentProducts as $product)
                    <div class="flex items-center justify-between text-sm">
                        <a href="{{ route('products.show', $product) }}" class="text-ink-primary hover:text-gold-soft truncate">{{ $product->title }}</a>
                        <span class="text-ink-secondary text-xs">{{ $product->user->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-vault-obsidian border border-vault-border rounded p-5">
            <h3 class="font-serif font-semibold text-gold-soft mb-3">ผู้ใช้ล่าสุด</h3>
            <div class="space-y-3">
                @foreach ($recentUsers as $user)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-ink-primary">{{ $user->name }}</span>
                        <span class="text-ink-secondary text-xs">{{ $user->email }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin.layout>