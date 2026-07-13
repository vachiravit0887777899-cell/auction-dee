<?php

namespace App\Events;

use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Bid $bid)
    {
        //
    }

    // กำหนดว่า event นี้จะกระจายไปที่ channel ไหน
    public function broadcastOn(): array
    {
        return [
            new Channel('product.' . $this->bid->product_id),
        ];
    }

    // ตั้งชื่อ event ฝั่ง frontend (ถ้าไม่ตั้ง Laravel จะใช้ชื่อ class เต็มแทน ยาวเกินไป)
    public function broadcastAs(): string
    {
        return 'NewBidPlaced';
    }

    // กำหนดข้อมูลที่จะส่งไปให้ frontend (เลือกเฉพาะที่จำเป็น ไม่ส่งทั้ง object)
    public function broadcastWith(): array
    {
        return [
            'amount' => number_format($this->bid->amount, 2),
            'raw_amount' => $this->bid->amount,
            'bidder_name' => $this->bid->user->name,
            'product_id' => $this->bid->product_id,
            'created_at' => $this->bid->created_at->format('H:i:s'),
        ];
    }
}