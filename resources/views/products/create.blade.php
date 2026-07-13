<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ลงสินค้าประมูลใหม่') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อสินค้า</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">รายละเอียดสินค้า</label>
                        <textarea name="description" rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">รูปภาพสินค้า (ไม่บังคับ)</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ราคาเริ่มต้น (บาท)</label>
                            <input type="number" step="0.01" name="starting_price" value="{{ old('starting_price') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ขั้นต่ำการบิดเพิ่ม (บาท)</label>
                            <input type="number" step="0.01" name="bid_increment" value="{{ old('bid_increment', 10) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">เวลาปิดประมูล</label>
                        <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                        ลงประมูล
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>