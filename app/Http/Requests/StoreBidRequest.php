<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreBidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // เช็ค auth ผ่าน middleware ที่ route แทน
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $product = $this->route('product');
            $user = $this->user();
            $amount = $this->input('amount');

            // ห้ามบิดสินค้าตัวเอง
            if ($product->user_id === $user->id) {
                $validator->errors()->add('amount', 'คุณไม่สามารถบิดสินค้าของตัวเองได้');
                return;
            }

            // เช็คว่าสินค้ายัง active และยังไม่หมดเวลา
            if ($product->status !== 'active' || now()->greaterThan($product->ends_at)) {
                $validator->errors()->add('amount', 'การประมูลนี้ปิดแล้ว');
                return;
            }

            // เช็คว่าราคาบิดสูงพอ
            $minimumBid = $product->current_price + $product->bid_increment;
            if ($amount < $minimumBid) {
                $validator->errors()->add('amount', "ราคาบิดต้องอย่างน้อย ฿" . number_format($minimumBid, 2));
            }
        });
    }
}