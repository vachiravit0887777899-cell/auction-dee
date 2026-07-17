<x-admin.layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-serif text-2xl font-semibold text-gold-soft">จัดการผู้ใช้</h1>
        <p class="text-sm text-ink-secondary">{{ $users->total() }} คน</p>
    </div>

    <div class="bg-vault-obsidian border border-vault-border rounded overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-vault-black text-ink-secondary uppercase text-[10px] tracking-widest">
                <tr>
                    <th class="px-6 py-3.5 font-medium">ชื่อ</th>
                    <th class="px-6 py-3.5 font-medium">อีเมล</th>
                    <th class="px-6 py-3.5 font-medium">สินค้าที่ลง</th>
                    <th class="px-6 py-3.5 font-medium">จำนวนบิด</th>
                    <th class="px-6 py-3.5 font-medium">สิทธิ์</th>
                    <th class="px-6 py-3.5 font-medium">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-vault-border">
                @foreach ($users as $user)
                    <tr class="hover:bg-vault-stone/50">
                        <td class="px-6 py-4 font-medium text-ink-primary">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-ink-secondary">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-ink-secondary">{{ $user->products_count }}</td>
                        <td class="px-6 py-4 text-ink-secondary">{{ $user->bids_count }}</td>
                        <td class="px-6 py-4">
                            @if ($user->is_admin)
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-gold/10 text-gold-soft border border-gold/30 rounded">Admin</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] uppercase tracking-wide bg-vault-stone text-ink-secondary border border-vault-border rounded">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-medium text-gold-soft hover:underline">
                                        {{ $user->is_admin ? 'ถอดสิทธิ์ Admin' : 'ตั้งเป็น Admin' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-ink-secondary/40">คุณเอง</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</x-admin.layout>