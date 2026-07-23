<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Tìm kiếm
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('brand', 'like', "%$keyword%")
                  ->orWhere('description', 'like', "%$keyword%");
            });
        }

        // Lọc danh mục
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Lọc thương hiệu
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Lọc giá
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            'rating'     => $query->orderByDesc('rating_total'),
            default      => $query->orderByDesc('created_at'),
        };

        $products   = $query->paginate(12)->appends($request->all());
        $categories = Product::where('is_active', true)->distinct()->pluck('category');
        $brands     = Product::where('is_active', true)->distinct()->pluck('brand');

        return view('pages.products', compact('products', 'categories', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Sản phẩm liên quan
        $related = Product::where('category', $product->category)
                          ->where('id', '!=', $product->id)
                          ->where('is_active', true)
                          ->take(4)
                          ->get();

        return view('pages.product-detail', compact('product', 'related'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}
