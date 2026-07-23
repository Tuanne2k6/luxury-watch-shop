<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Lấy giỏ hàng từ session
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart  = $this->getCart();
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        return view('pages.cart', compact('cart', 'total'));
    }

    public function add(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);

        if (!$product->in_stock) {
            return back()->with('error', 'Sản phẩm đã hết hàng!');
        }

        $cart     = $this->getCart();
        $qty      = max(1, (int) $request->input('quantity', 1));
        $key      = (string) $productId;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'id'        => $product->id,
                'name'      => $product->name,
                'brand'     => $product->brand,
                'price'     => $product->price,
                'image'     => $product->image,
                'image_url' => $product->image_url,
                'slug'      => $product->slug,
                'quantity'  => $qty,
            ];
        }

        $this->saveCart($cart);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'count' => array_sum(array_column($cart, 'quantity'))]);
        }

        return back()->with('success', "Đã thêm \"{$product->name}\" vào giỏ hàng!");
    }

    public function update(Request $request, int $productId)
    {
        $cart = $this->getCart();
        $key  = (string) $productId;
        $qty  = (int) $request->input('quantity', 1);

        if ($qty <= 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['quantity'] = $qty;
        }

        $this->saveCart($cart);
        return back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove(int $productId)
    {
        $cart = $this->getCart();
        unset($cart[(string) $productId]);
        $this->saveCart($cart);
        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        $this->saveCart([]);
        return back()->with('success', 'Đã xoá toàn bộ giỏ hàng!');
    }

    // Lấy số lượng cho header badge (AJAX)
    public function count()
    {
        $cart  = $this->getCart();
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }
}
