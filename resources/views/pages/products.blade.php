{{-- resources/views/pages/products.blade.php --}}
@extends('layouts.app')
@section('title', 'Sản phẩm – Luxury Watch')

@section('content')

@include('partials.alert')

<div class="page-banner">
    <div class="container">
        <h1>Sản phẩm</h1>
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <span>Sản phẩm</span>
        </nav>
    </div>
</div>

<div class="shop-layout container" style="max-width:1240px;margin:0 auto;padding:3rem 1.5rem;">

    {{-- ── SIDEBAR LỌC ── --}}
    <aside class="shop-sidebar">
        <form action="{{ route('products.index') }}" method="GET">

            <div class="filter-box">
                <h3 class="filter-title">Tìm kiếm</h3>
                <div class="filter-search">
                    <input type="text" name="q"
                           value="{{ request('q') }}"
                           placeholder="Tên, thương hiệu...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>

            {{-- Danh mục từ DB --}}
            <div class="filter-box">
                <h3 class="filter-title">Danh mục</h3>
                <ul class="filter-list">
                    <li>
                        <label>
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            Tất cả
                        </label>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <label>
                            <input type="radio" name="category" value="{{ $cat }}"
                                   {{ request('category') == $cat ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            {{ $cat }}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Thương hiệu từ DB --}}
            <div class="filter-box">
                <h3 class="filter-title">Thương hiệu</h3>
                <ul class="filter-list">
                    <li>
                        <label>
                            <input type="radio" name="brand" value=""
                                   {{ !request('brand') ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            Tất cả
                        </label>
                    </li>
                    @foreach($brands as $brand)
                    <li>
                        <label>
                            <input type="radio" name="brand" value="{{ $brand }}"
                                   {{ request('brand') == $brand ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            {{ $brand }}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="filter-box">
                <h3 class="filter-title">Khoảng giá</h3>
                <div class="price-range-inputs">
                    <input type="number" name="min_price"
                           placeholder="Từ (đ)"
                           value="{{ request('min_price') }}" min="0">
                    <span>–</span>
                    <input type="number" name="max_price"
                           placeholder="Đến (đ)"
                           value="{{ request('max_price') }}" min="0">
                </div>
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <button type="submit" class="btn-filter-apply">Áp dụng</button>
            </div>

            @if(request('q') || request('category') || request('brand') || request('min_price') || request('max_price'))
            <a href="{{ route('products.index') }}" class="btn-filter-clear">
                <i class="fas fa-times"></i> Xoá bộ lọc
            </a>
            @endif

        </form>
    </aside>

    {{-- ── DANH SÁCH SẢN PHẨM ── --}}
    <div class="shop-main">
        <div class="shop-toolbar">
            <p class="results-count">
                Tìm thấy <strong>{{ $products->total() }}</strong> sản phẩm
                @if(request('q'))
                    cho "<em>{{ request('q') }}</em>"
                @endif
            </p>
            <div class="sort-wrapper">
                <label>Sắp xếp:</label>
                <select onchange="applySort(this.value)">
                    <option value="latest"     {{ request('sort','latest') == 'latest'    ? 'selected':'' }}>Mới nhất</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'          ? 'selected':'' }}>Giá: Thấp → Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc'         ? 'selected':'' }}>Giá: Cao → Thấp</option>
                    <option value="rating"     {{ request('sort') == 'rating'             ? 'selected':'' }}>Đánh giá cao</option>
                    <option value="name_asc"   {{ request('sort') == 'name_asc'           ? 'selected':'' }}>Tên A–Z</option>
                </select>
            </div>
        </div>

        @if($products->isEmpty())
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>Không tìm thấy sản phẩm</h3>
            <p>Thử thay đổi bộ lọc hoặc từ khoá tìm kiếm.</p>
            <a href="{{ route('products.index') }}" class="btn-view-all">Xem tất cả</a>
        </div>
        @else
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-image-wrapper">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset('images/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="product-image"
                             onerror="this.src='https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=400'">
                    </a>

                    @if($product->original_price > 0 && $product->original_price > $product->price)
                        @php $giam = round(($product->original_price - $product->price) / $product->original_price * 100) @endphp
                        <div class="product-badge badge-sale">-{{ $giam }}%</div>
                    @endif

                    @if($product->stock == 0)
                        <div class="product-badge badge-out">Hết hàng</div>
                    @endif

                    <div class="product-overlay-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="overlay-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="overlay-btn">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="product-info">
                    <p class="product-brand">{{ $product->brand }}</p>
                    <h3 class="product-name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>

                    @php
                        $rating = $product->rating_count > 0
                            ? round($product->rating_total / $product->rating_count, 1)
                            : 0;
                    @endphp
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="rating-count">({{ $product->rating_count }})</span>
                    </div>

                    <div class="product-price">
                        <span class="price-current">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @if($product->original_price > 0)
                            <span class="price-old">{{ number_format($product->original_price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>

                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-cart">
                            <i class="fas fa-shopping-bag"></i> Thêm vào giỏ
                        </button>
                    </form>
                    @else
                    <button class="btn-add-cart btn-out-stock" disabled>
                        <i class="fas fa-times-circle"></i> Hết hàng
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── PAGINATION – dùng custom view ── --}}
        <div class="pagination-wrapper">
            {{ $products->links('vendor.pagination.custom') }}
        </div>

        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
function applySort(value) {
    var url = new URL(window.location.href);
    url.searchParams.set('sort', value);
    window.location.href = url.toString();
}
</script>
@endpush
