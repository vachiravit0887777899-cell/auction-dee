<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // เช็ค auth ผ่าน middleware ที่ route แล้ว
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:2048'], // สูงสุด 2MB
            'starting_price' => ['required', 'numeric', 'min:1'],
            'bid_increment' => ['required', 'numeric', 'min:1'],
            'ends_at' => ['required', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'กรุณากรอกชื่อสินค้า',
            'description.required' => 'กรุณากรอกรายละเอียดสินค้า',
            'starting_price.required' => 'กรุณากรอกราคาเริ่มต้น',
            'starting_price.min' => 'ราคาเริ่มต้นต้องมากกว่า 0',
            'bid_increment.required' => 'กรุณากรอกขั้นต่ำการบิดเพิ่ม',
            'ends_at.required' => 'กรุณาเลือกเวลาปิดประมูล',
            'ends_at.after' => 'เวลาปิดประมูลต้องอยู่ในอนาคต',
            'image.max' => 'รูปภาพต้องมีขนาดไม่เกิน 2MB',
        ];
    }
}