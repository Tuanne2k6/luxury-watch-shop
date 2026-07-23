@extends('layouts.admin')
@section('title', 'Quản lý sản phẩm')

@section('content')

<div class="toolbar">
    <form method="GET" action="{{ route('admin.products.index') }}" style="display:contents">
        <input type="text" name="q" class="search-input" placeholder="Tìm tên, thương hiệu..." value="{{ request('q') }}">
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Tất cả danh mục</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-outline"><i class="fas fa-search"></i></button>
        @if(request('q') || request('category'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline"><i class="fas fa-times"></i> Xóa lọc</a>
        @endif
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-gold" style="margin-left:auto">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>Danh sách sản phẩm ({{ $products->total() }})</h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Thương hiệu</th>
                    <th>Danh mục</th>
                    <th class="text-right">Giá bán</th>
                    <th class="text-center">Tồn kho</th>
                    <th class="text-center">Nổi bật</th>
                    <th class="text-center">Hiển thị</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{ asset('images/' . $product->image) }}"
                             class="product-thumb"
                             onerror="this.src='https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=80'">
                    </td>
                    <td>
                        <strong style="font-size:13.5px">{{ Str::limit($product->name, 40) }}</strong>
                    </td>
                    <td class="text-muted">{{ $product->brand }}</td>
                    <td class="text-muted">{{ $product->category }}</td>
                    <td class="text-right">
                        <strong>{{ number_format($product->price, 0, ',', '.') }}đ</strong>
                        @if($product->original_price > 0)
                        <br><small class="text-muted" style="text-decoration:line-through">{{ number_format($product->original_price, 0, ',', '.') }}đ</small>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="{{ $product->stock > 0 ? 'badge badge-active' : 'badge badge-inactive' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $product->is_featured ? 'btn-gold' : 'btn-outline' }}"
                                    title="{{ $product->is_featured ? 'Đang nổi bật' : 'Chưa nổi bật' }}">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('admin.products.toggle-active', $product) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-outline' }}"
                                    title="{{ $product->is_active ? 'Đang hiện' : 'Đang ẩn' }}">
                                <i class="fas fa-{{ $product->is_active ? 'eye' : 'eye-slash' }}"></i>
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <div class="flex" style="justify-content:center">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Xóa sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted" style="padding:32px">
                        <i class="fas fa-box-open" style="font-size:32px;margin-bottom:8px;display:block;opacity:.3"></i>
                        Không có sản phẩm nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $products->appends(request()->all())->links() }}

@endsection
