<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Notifications\AuctionEnded;
use App\Notifications\AuctionWon;
use Illuminate\Console\Command;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auctions:close-expired';

    protected $description = 'Close expired auctions automatically and announce the winner';

    public function handle(): void
    {
        $expiredProducts = Product::where('status', 'active')
            ->where('ends_at', '<', now())
            ->get();

        if ($expiredProducts->isEmpty()) {
            $this->info('No expired auctions found.');
            return;
        }

        foreach ($expiredProducts as $product) {
            $highestBid = $product->bids()->orderByDesc('amount')->first();

            $product->update([
                'status' => 'ended',
                'winner_id' => $highestBid?->user_id,
            ]);

            // Notify the seller always
            $product->user->notify(new AuctionEnded($product));

            // Notify the winner if there is one
            if ($highestBid) {
                $highestBid->user->notify(new AuctionWon($product));
            }

            $this->info("Closed: {$product->title} " .
                ($highestBid ? "(Winner user_id: {$highestBid->user_id})" : "(No bids)"));
        }

        $this->info("Total closed: {$expiredProducts->count()}");
    }
}