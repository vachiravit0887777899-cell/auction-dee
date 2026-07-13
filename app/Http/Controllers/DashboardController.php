<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // สินค้าที่ตัวเองลงขาย พร้อมนับจำนวนการบิด
        $myProducts = Product::where('user_id', $user->id)
            ->withCount('bids')
            ->latest()
            ->get();

        // สินค้าที่ตัวเองเคยบิด (เอาราคาสูงสุดที่ตัวเองเคยบิดต่อสินค้าแต่ละชิ้น)
        $myBids = Bid::where('user_id', $user->id)
            ->select('product_id', DB::raw('MAX(amount) as my_highest_bid'))
            ->groupBy('product_id')
            ->with('product')
            ->get()
            ->filter(fn ($bid) => $bid->product !== null) // กันกรณีสินค้าถูกลบไปแล้ว
            ->sortByDesc(fn ($bid) => $bid->product->updated_at);

        return view('dashboard', compact('myProducts', 'myBids'));
    }
}