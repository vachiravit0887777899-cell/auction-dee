<x-admin.layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">จัดการสินค้า</h1>
        <p class="text-sm text-gray-500">{{ $products->total() }} รายการ</p>
    </div>

    <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50/50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3.5">สินค้า</th>
                    <th class="px-6 py-3.5">เจ้าของ</th>
                    <th class="px-6 py-3.5">ราคาปัจจุบัน</th>
                    <th class="px-6 py-3.5">บิด</th>
                    <th class="px-6 py-3.5">สถานะ</th>
                    <th class="px-6 py-3.5">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4">
                            <a href="{{ route('products.show', $product) }}" class="font-semibold text-gray-800 hover:text-primary-600">
                                {{ Str::limit($product->title, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $product->user->name }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-700">฿{{ number_format($product->current_price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $product->bids_count }}</td>
                        <td class="px-6 py-4">
                            @if ($product->status === 'active')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-success-500/10 text-success-500">กำลังประมูล</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">ปิดแล้ว</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('ยืนยันลบสินค้านี้? การกระทำนี้ไม่สามารถย้อนกลับได้');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger-500 hover:text-danger-600 flex items-center gap-1 text-xs font-medium">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-admin.layout>