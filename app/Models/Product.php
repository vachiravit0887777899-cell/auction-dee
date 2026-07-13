<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'starting_price',
        'current_price',
        'bid_increment',
        'starts_at',
        'ends_at',
        'status',
        'winner_id',
    ];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'bid_increment' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    // ผู้ขาย/คนลงประมูลสินค้านี้
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ผู้ชนะการประมูล
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // ประวัติการบิดทั้งหมดของสินค้านี้
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    // ดึงการบิดล่าสุด (ราคาสูงสุด) แบบสะดวก
    public function highestBid(): HasMany
    {
        return $this->hasMany(Bid::class)->latest('amount');
    }

    // เช็คว่าการประมูลนี้ยังเปิดอยู่ไหม
    public function isActive(): bool
    {
        return $this->status === 'active' && now()->between($this->starts_at, $this->ends_at);
    }
}