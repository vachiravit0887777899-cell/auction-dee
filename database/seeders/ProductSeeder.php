<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง user ทดสอบ 5 คน (ไว้เป็นคนบิด)
        $users = User::factory(5)->create();

        // สร้างสินค้าประมูล 10 ชิ้น ที่กำลัง active อยู่
        $products = Product::factory(10)->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // สุ่มสร้างการบิดให้บางสินค้า
        foreach ($products as $product) {
            $bidCount = fake()->numberBetween(0, 5);
            $currentPrice = $product->starting_price;

            for ($i = 0; $i < $bidCount; $i++) {
                $currentPrice += $product->bid_increment;

                Bid::create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                    'amount' => $currentPrice,
                ]);
            }

            // อัปเดตราคาปัจจุบันของสินค้าให้ตรงกับ bid ล่าสุด
            if ($bidCount > 0) {
                $product->update(['current_price' => $currentPrice]);
            }
        }

        // สร้างสินค้าที่หมดเวลาแล้ว 2 ชิ้น (ไว้ทดสอบ scheduler ทีหลัง)
        Product::factory(2)->ended()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
    }
}