<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuctionWon extends Notification implements ShouldQueue
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
        return [
            'type' => 'auction_won',
            'product_id' => $this->product->id,
            'product_title' => $this->product->title,
            'final_price' => $this->product->current_price,
            'message' => "🎉 ยินดีด้วย! คุณชนะการประมูล \"{$this->product->title}\" ด้วยราคา ฿" . number_format($this->product->current_price, 2),
        ];
    }
}