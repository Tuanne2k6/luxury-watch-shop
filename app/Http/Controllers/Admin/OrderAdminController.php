<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('q')) {
            $kw = $request->q;
            $query->where(fn($q) => $q->where('order_code','like',"%$kw%")
                ->orWhere('customer_name','like',"%$kw%")
                ->orWhere('customer_email','like',"%$kw%")
                ->orWhere('customer_phone','like',"%$kw%"));
        }
        $orders = $query->paginate(15)->appends($request->all());
        $statusCounts = [
            'all'       => Order::count(),
            'pending'   => Order::where('status','pending')->count(),
            'confirmed' => Order::where('status','confirmed')->count(),
            'shipping'  => Order::where('status','shipping')->count(),
            'delivered' => Order::where('status','delivered')->count(),
            'cancelled' => Order::where('status','cancelled')->count(),
        ];
        return view('admin.orders.index', compact('orders','statusCounts'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,shipping,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng!');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return back()->with('success', 'Đã xóa đơn hàng!');
    }
}
