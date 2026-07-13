<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    // สินค้าที่ถูกบิด
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ผู้ที่บิด
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}