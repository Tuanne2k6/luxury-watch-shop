<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('q')) {
            $kw = $request->q;
            $query->where(function($q) use ($kw) {
                $q->where('name', 'like', "%$kw%")->orWhere('brand', 'like', "%$kw%");
            });
        }
        if ($request->filled('category')) $query->where('category', $request->category);
        $products   = $query->orderByDesc('created_at')->paginate(12)->appends($request->all());
        $categories = Product::distinct()->pluck('category');
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Product::distinct()->pluck('category');
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'brand'    => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
        ]);

        $data = $request->only(['name','brand','category','price','original_price','description','stock']);
        $data['slug']        = Str::slug($request->name) . '-' . uniqid();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->filled('features_text')) {
            $data['features'] = json_encode(array_values(array_filter(array_map('trim', explode("\n", $request->features_text)))));
        }
        if ($request->filled('specifications_text')) {
            $specs = [];
            foreach (explode("\n", $request->specifications_text) as $line) {
                if (str_contains($line, ':')) { [$k,$v] = explode(':', $line, 2); $specs[trim($k)] = trim($v); }
            }
            $data['specifications'] = json_encode($specs);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $data['image'] = 'products/' . $fileName;
        } else {
            $data['image'] = 'products/default.jpg';
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Product::distinct()->pluck('category');
        $featuresText = '';
        if ($product->features) {
            $arr = is_array($product->features) ? $product->features : (json_decode($product->features, true) ?? []);
            $featuresText = implode("\n", $arr);
        }
        $specificationsText = '';
        if ($product->specifications) {
            $specs = is_array($product->specifications) ? $product->specifications : (json_decode($product->specifications, true) ?? []);
            foreach ($specs as $k => $v) $specificationsText .= "$k: $v\n";
            $specificationsText = trim($specificationsText);
        }
        return view('admin.products.edit', compact('product','categories','featuresText','specificationsText'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'brand'    => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
        ]);

        $data = $request->only(['name','brand','category','price','original_price','description','stock']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->filled('features_text')) {
            $data['features'] = json_encode(array_values(array_filter(array_map('trim', explode("\n", $request->features_text)))));
        } else { $data['features'] = null; }

        if ($request->filled('specifications_text')) {
            $specs = [];
            foreach (explode("\n", $request->specifications_text) as $line) {
                if (str_contains($line, ':')) { [$k,$v] = explode(':', $line, 2); $specs[trim($k)] = trim($v); }
            }
            $data['specifications'] = json_encode($specs);
        } else { $data['specifications'] = null; }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $data['image'] = 'products/' . $fileName;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return back()->with('success', 'Đã cập nhật trạng thái nổi bật!');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Đã cập nhật trạng thái hiển thị!');
    }
}
