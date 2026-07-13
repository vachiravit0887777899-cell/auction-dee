<x-admin.layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">จัดการผู้ใช้</h1>
        <p class="text-sm text-gray-500">{{ $users->total() }} คน</p>
    </div>

    <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50/50 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3.5">ชื่อ</th>
                    <th class="px-6 py-3.5">อีเมล</th>
                    <th class="px-6 py-3.5">สินค้าที่ลง</th>
                    <th class="px-6 py-3.5">จำนวนบิด</th>
                    <th class="px-6 py-3.5">สิทธิ์</th>
                    <th class="px-6 py-3.5">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->products_count }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->bids_count }}</td>
                        <td class="px-6 py-4">
                            @if ($user->is_admin)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-primary-50 text-primary-600">Admin</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-medium text-primary-600 hover:underline">
                                        {{ $user->is_admin ? 'ถอดสิทธิ์ Admin' : 'ตั้งเป็น Admin' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-300">คุณเอง</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</x-admin.layout>