<x-admin.layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-serif text-2xl font-semibold text-gold-soft">จัดการสินค้า</h1>
        <p class="text-sm text-ink-secondary">{{ $products->total() }} รายการ</p>
    </div>

    <div class="bg-vault-obsidian border border-vault-border rounded overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-vault-black text-ink-secondary uppercase text-[10px] tracking-widest">
                <tr>
                    <th class="px-6 py-3.5 font-medium">สินค้า</th>
                    <th class="px-6 py-3.5 font-medium">เจ้าของ</th>
                    <th class="px-6 py-3.5 font-medium">ราคาปัจจุบัน</th>
                    <th class="px-6 py-3.5 font-medium">บิด</th>
                    <th class="px-6 py-3.5 font-medium">สถานะ</th>
                    <th class="px-6 py-3.5 font-medium">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-vault-border">
                @foreach ($products as $product)
                    <tr class="hover:bg-vault-stone/50">
                        <td class="px-6 py-4">
                            <a href="{{ route('products.show', $product) }}" class="font-medium text-ink-primary hover:text-gold-soft">
                                {{ Str::limit($product->title, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-ink-secondary">{{ $product->user->name }}</td>
                        <td class="px-6 py-4 font-serif font-semibold text-gold-soft">฿{{ number_format($product->current_price, 2) }}</td>
                        <td class="px-6 py-4 text-ink-secondary">{{ $product->bids_count }}</td>
                        <td class="px-6 py-4">
                            @if ($product->status === 'active')
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-gold/10 text-gold-soft border border-gold/30 rounded">กำลังประมูล</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-stone text-ink-secondary border border-vault-border rounded">ปิดแล้ว</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.products.edit', $product) }}" class="text-gold-soft hover:text-gold-soft/70 flex items-center gap-1 text-xs font-medium">
            <i data-lucide="pencil" class="w-3.5 h-3.5"></i> แก้ไข
        </a>
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
              onsubmit="return confirm('ยืนยันลบสินค้านี้? การกระทำนี้ไม่สามารถย้อนกลับได้');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 flex items-center gap-1 text-xs font-medium">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> ลบ
            </button>
        </form>
    </div>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-admin.layout>