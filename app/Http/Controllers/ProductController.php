<?php

namespace App\Http\Controllers;

use App\Events\NewBidPlaced;
use App\Http\Requests\StoreBidRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // หน้ารายการสินค้าทั้งหมด
    public function index(Request $request)
    {
        $products = Product::where('status', 'active')
            ->withCount('bids')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('ends_at')
            ->paginate(9)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    // หน้ารายละเอียดสินค้า
    public function show(Product $product)
    {
        $product->load(['bids' => function ($query) {
            $query->with('user')->latest('amount')->limit(10);
        }, 'user', 'winner']);

        return view('products.show', compact('product'));
    }

    // หน้าฟอร์มสร้างสินค้าใหม่
    public function create()
    {
        return view('products.create');
    }

    // บันทึกสินค้าใหม่
    public function store(StoreProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price,
            'bid_increment' => $request->bid_increment,
            'starts_at' => now(),
            'ends_at' => $request->ends_at,
            'status' => 'active',
        ]);

        return redirect()->route('products.show', $product)
            ->with('success', 'ลงสินค้าประมูลสำเร็จ!');
    }

    // บันทึกการบิดใหม่
    public function bid(StoreBidRequest $request, Product $product)
    {
        $bid = DB::transaction(function () use ($request, $product) {
            $product = Product::lockForUpdate()->findOrFail($product->id);

            $bid = $product->bids()->create([
                'user_id' => $request->user()->id,
                'amount' => $request->amount,
            ]);

            $product->update([
                'current_price' => $request->amount,
            ]);

            return $bid;
        });

        broadcast(new NewBidPlaced($bid->load('user')))->toOthers();

        return back()->with('success', 'บิดสำเร็จ!');
    }
}