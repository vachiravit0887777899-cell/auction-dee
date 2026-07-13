<x-admin.layout>
    <h1 class="text-2xl font-extrabold text-gray-900 mb-6">ภาพรวมระบบ</h1>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-gray-500 mt-1">ผู้ใช้ทั้งหมด</p>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['total_products'] }}</p>
            <p class="text-xs text-gray-500 mt-1">สินค้าทั้งหมด</p>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-success-500">{{ $stats['active_products'] }}</p>
            <p class="text-xs text-gray-500 mt-1">กำลังประมูล</p>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-gray-500">{{ $stats['ended_products'] }}</p>
            <p class="text-xs text-gray-500 mt-1">ปิดแล้ว</p>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-gray-900">{{ $stats['total_bids'] }}</p>
            <p class="text-xs text-gray-500 mt-1">จำนวนบิดทั้งหมด</p>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <p class="text-2xl font-extrabold text-primary-600">฿{{ number_format($stats['total_sold_value'], 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">มูลค่าขายสำเร็จรวม</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-3">สินค้าล่าสุด</h3>
            <div class="space-y-3">
                @foreach ($recentProducts as $product)
                    <div class="flex items-center justify-between text-sm">
                        <a href="{{ route('products.show', $product) }}" class="text-gray-700 hover:text-primary-600 truncate">{{ $product->title }}</a>
                        <span class="text-gray-400 text-xs">{{ $product->user->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-3">ผู้ใช้ล่าสุด</h3>
            <div class="space-y-3">
                @foreach ($recentUsers as $user)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-700">{{ $user->name }}</span>
                        <span class="text-gray-400 text-xs">{{ $user->email }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin.layout>