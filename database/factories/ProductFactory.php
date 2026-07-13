<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $startingPrice = fake()->randomFloat(2, 100, 5000);

        return [
            'user_id' => User::factory(),
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'image' => null,
            'starting_price' => $startingPrice,
            'current_price' => $startingPrice,
            'bid_increment' => fake()->randomElement([10, 20, 50, 100]),
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDays(fake()->numberBetween(1, 7)),
            'status' => 'active',
            'winner_id' => null,
        ];
    }

    // state สำหรับสินค้าที่หมดเวลาแล้ว (ไว้ทดสอบ scheduler ปิดประมูลทีหลัง)
    public function ended(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subDays(3),
            'ends_at' => now()->subHour(),
            'status' => 'active', // ยัง active แต่หมดเวลาแล้ว ไว้ทดสอบว่า scheduler เจอแล้วปิดให้ไหม
        ]);
    }
}