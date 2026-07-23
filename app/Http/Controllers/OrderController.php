<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        return view('pages.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_email'   => 'required|email',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ], [
            'customer_name.required'    => 'Vui lòng nhập họ tên.',
            'customer_email.required'   => 'Vui lòng nhập email.',
            'customer_email.email'      => 'Email không hợp lệ.',
            'customer_phone.required'   => 'Vui lòng nhập số điện thoại.',
            'customer_address.required' => 'Vui lòng nhập địa chỉ.',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total       = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $shippingFee = $total >= 2000000 ? 0 : 30000;

        $order = Order::create([
            'order_code'       => Order::generateCode(),
            'customer_name'    => $request->customer_name,
            'customer_email'   => $request->customer_email,
            'customer_phone'   => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount'     => $total + $shippingFee,
            'shipping_fee'     => $shippingFee,
            'note'             => $request->note,
            'status'           => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
            ]);
        }

        session(['cart' => []]);

        return redirect()->route('order.success', $order->order_code);
    }

    public function success(string $code)
    {
        $order = Order::where('order_code', $code)->with('items')->firstOrFail();
        return view('pages.order-success', compact('order'));
    }
}
