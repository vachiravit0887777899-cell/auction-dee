<x-admin.layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.products') }}" class="text-ink-secondary hover:text-gold-soft">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <h1 class="font-serif text-2xl font-semibold text-gold-soft">แก้ไขสินค้า</h1>
    </div>

    <div class="bg-vault-obsidian border border-vault-border rounded p-8 max-w-2xl">

        @if ($errors->any())
            <div class="bg-red-500/10 text-red-400 border border-red-500/20 p-4 rounded mb-6 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PATCH')

    <div>
        <x-input-label value="รูปภาพปัจจุบัน" />
        <div class="w-full h-48 bg-vault-black border border-vault-border rounded overflow-hidden flex items-center justify-center mb-3">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover">
            @else
                <i data-lucide="gem" class="w-10 h-10 text-ink-secondary/30"></i>
            @endif
        </div>
        <x-input-label value="เปลี่ยนรูปภาพ (ไม่บังคับ — เว้นว่างถ้าไม่ต้องการเปลี่ยน)" />
        <input type="file" name="image" accept="image/*"
               class="w-full text-sm text-ink-secondary file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:uppercase file:tracking-widest file:bg-gold/10 file:text-gold-soft hover:file:bg-gold/20">
    </div>

    <div>
        <x-input-label value="ชื่อสมบัติ" />
        <x-text-input type="text" name="title" value="{{ old('title', $product->title) }}" />
    </div>

            <div>
                <x-input-label value="รายละเอียดสมบัติ" />
                <textarea name="description" rows="4"
                          class="w-full bg-vault-black border-vault-border focus:border-gold focus:ring-gold rounded shadow-sm text-sm text-ink-primary placeholder:text-ink-secondary/50">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label value="ราคาเริ่มต้น (บาท)" />
                    <x-text-input type="number" step="0.01" name="starting_price" value="{{ old('starting_price', $product->starting_price) }}" />
                </div>
                <div>
                    <x-input-label value="ขั้นต่ำการบิดเพิ่ม (บาท)" />
                    <x-text-input type="number" step="0.01" name="bid_increment" value="{{ old('bid_increment', $product->bid_increment) }}" />
                </div>
            </div>

            <div>
                <x-input-label value="เวลาปิดประมูล" />
                <x-text-input type="datetime-local" name="ends_at"
                              value="{{ old('ends_at', $product->ends_at->format('Y-m-d\TH:i')) }}" />
            </div>

            <div>
                <x-input-label value="สถานะ" />
                <select name="status" class="w-full bg-vault-black border-vault-border focus:border-gold focus:ring-gold rounded shadow-sm text-sm text-ink-primary [color-scheme:dark]">
                    <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>กำลังประมูล (active)</option>
                    <option value="ended" {{ $product->status === 'ended' ? 'selected' : '' }}>ปิดแล้ว (ended)</option>
                    <option value="cancelled" {{ $product->status === 'cancelled' ? 'selected' : '' }}>ยกเลิก (cancelled)</option>
                </select>
            </div>

            <div class="flex gap-3">
                <x-primary-button>
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> บันทึกการแก้ไข
                </x-primary-button>
                <a href="{{ route('admin.products') }}"
                   class="px-5 py-3 text-xs uppercase tracking-widest text-ink-secondary border border-vault-border rounded hover:border-gold/40 transition flex items-center">
                    ยกเลิก
                </a>
            </div>
        </form>

    </div>
</x-admin.layout>