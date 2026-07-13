<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuctionEnded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Product $product)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $hasWinner = $this->product->winner_id !== null;

        return [
            'type' => 'auction_ended',
            'product_id' => $this->product->id,
            'product_title' => $this->product->title,
            'final_price' => $this->product->current_price,
            'has_winner' => $hasWinner,
            'message' => $hasWinner
                ? "การประมูล \"{$this->product->title}\" ปิดแล้ว ขายได้ ฿" . number_format($this->product->current_price, 2)
                : "การประมูล \"{$this->product->title}\" ปิดแล้ว แต่ไม่มีผู้เข้าร่วมประมูล",
        ];
    }
}