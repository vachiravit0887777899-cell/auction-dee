<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-semibold text-gold-soft">ลงสมบัติประมูลใหม่</h2>
    </x-slot>

    <div class="py-14">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-vault-obsidian border border-vault-border rounded p-8">

                @if ($errors->any())
                    <div class="bg-red-500/10 text-red-400 border border-red-500/20 p-4 rounded mb-6 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label value="ชื่อสมบัติ" />
                        <x-text-input type="text" name="title" value="{{ old('title') }}" />
                    </div>

                    <div>
                        <x-input-label value="รายละเอียดสมบัติ" />
                        <textarea name="description" rows="4"
                                  class="w-full bg-vault-black border-vault-border focus:border-gold focus:ring-gold rounded shadow-sm text-sm text-ink-primary placeholder:text-ink-secondary/50">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <x-input-label value="รูปภาพสมบัติ (ไม่บังคับ)" />
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-sm text-ink-secondary file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:uppercase file:tracking-widest file:bg-gold/10 file:text-gold-soft hover:file:bg-gold/20">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="ราคาเริ่มต้น (บาท)" />
                            <x-text-input type="number" step="0.01" name="starting_price" value="{{ old('starting_price') }}" />
                        </div>
                        <div>
                            <x-input-label value="ขั้นต่ำการบิดเพิ่ม (บาท)" />
                            <x-text-input type="number" step="0.01" name="bid_increment" value="{{ old('bid_increment', 10) }}" />
                        </div>
                    </div>

                    <div>
                        <x-input-label value="เวลาปิดประมูล" />
                        <x-text-input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}" />
                    </div>

                    <x-primary-button>
                        <i data-lucide="gavel" class="w-4 h-4 mr-2"></i> ลงประมูล
                    </x-primary-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>