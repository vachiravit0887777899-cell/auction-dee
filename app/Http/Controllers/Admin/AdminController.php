<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // หน้า Dashboard สรุปภาพรวมระบบ
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'ended_products' => Product::where('status', 'ended')->count(),
            'total_bids' => Bid::count(),
            'total_sold_value' => Product::where('status', 'ended')->whereNotNull('winner_id')->sum('current_price'),
        ];

        $recentProducts = Product::with('user')->latest()->limit(5)->get();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentUsers'));
    }

    // รายการสินค้าทั้งหมด (สำหรับ admin จัดการ)
    public function products(Request $request)
    {
        $products = Product::with('user')
            ->withCount('bids')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products', compact('products'));
    }

    // ลบสินค้า (admin เท่านั้น)
    public function destroyProduct(Product $product)
    {
        $product->delete();

        return back()->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
    }

    // รายการ user ทั้งหมด
    public function users(Request $request)
    {
        $users = User::withCount(['products', 'bids'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users', compact('users'));
    }

    // สลับสิทธิ์ admin ของ user
    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'คุณไม่สามารถถอดสิทธิ์ admin ของตัวเองได้');
        }

        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', $user->is_admin
            ? "ตั้ง {$user->name} เป็น admin แล้ว"
            : "ถอดสิทธิ์ admin ของ {$user->name} แล้ว");
    }
}