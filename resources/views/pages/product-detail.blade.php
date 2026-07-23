{{-- resources/views/pages/product-detail.blade.php --}}
@extends('layouts.app')
@section('title', $product->name . ' – Luxury Watch')

@section('content')

@include('partials.alert')

<div class="page-banner page-banner-sm">
    <div class="container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('products.index') }}">Sản phẩm</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="container">
    <div class="product-detail-layout">

        {{-- ẢNH SẢN PHẨM --}}
        <div class="detail-gallery">
            <div class="detail-main-img">
                <img src="{{ asset('images/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     id="mainProductImg"
                     onerror="this.src='https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=700'">

                @if($product->original_price > 0 && $product->original_price > $product->price)
                    @php $giam = round(($product->original_price - $product->price) / $product->original_price * 100) @endphp
                    <div class="detail-badge">-{{ $giam }}%</div>
                @endif

                @if($product->stock == 0)
                    <div class="detail-badge badge-out">Hết hàng</div>
                @endif
            </div>
        </div>

        {{-- THÔNG TIN SẢN PHẨM --}}
        <div class="detail-info">
            <span class="detail-category">{{ $product->category }}</span>
            <h1 class="detail-name">{{ $product->name }}</h1>
            <p class="detail-brand">Thương hiệu: <strong>{{ $product->brand }}</strong></p>

            @php
                $rating = $product->rating_count > 0
                    ? round($product->rating_total / $product->rating_count, 1)
                    : 0;
            @endphp
            <div class="detail-rating">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span>{{ $rating }} / 5 ({{ $product->rating_count }} đánh giá)</span>
            </div>

            <div class="detail-price">
                <span class="price-main">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @if($product->original_price > 0)
                    <span class="price-strike">{{ number_format($product->original_price, 0, ',', '.') }}đ</span>
                    <span class="price-save">
                        Tiết kiệm {{ number_format($product->original_price - $product->price, 0, ',', '.') }}đ
                    </span>
                @endif
            </div>

            <p class="detail-desc">{{ $product->description }}</p>

            {{-- TÍNH NĂNG NỔI BẬT (Features) --}}
            @php
                $features = $product->features;
                if (is_string($features)) {
                    $features = json_decode($features, true);
                }
            @endphp
            @if(is_array($features) && count($features) > 0)
                <div class="detail-features">
                    <h3>Điểm nổi bật</h3>
                    <ul>
                        @foreach($features as $feat)
                            <li><i class="fas fa-check-circle"></i> {{ $feat }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- THÊM VÀO GIỎ --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="detail-add-form">
                @csrf
                <div class="qty-control">
                    <button type="button" onclick="changeQty(-1)">−</button>
                    <input type="number" name="quantity" id="qtyInput"
                           value="1" min="1" max="{{ $product->stock }}">
                    <button type="button" onclick="changeQty(1)">+</button>
                </div>
                <button type="submit" class="btn-detail-cart">
                    <i class="fas fa-shopping-bag"></i> Thêm vào giỏ hàng
                </button>
            </form>
            <p class="stock-info"><i class="fas fa-boxes"></i> Còn {{ $product->stock }} sản phẩm</p>
            @else
            <button class="btn-detail-cart btn-out-stock" disabled>
                <i class="fas fa-times-circle"></i> Hết hàng
            </button>
            @endif

            <div class="detail-policies">
                <div class="policy"><i class="fas fa-shield-alt"></i> Bảo hành 5 năm chính hãng</div>
                <div class="policy"><i class="fas fa-undo"></i> Đổi trả 30 ngày</div>
                <div class="policy"><i class="fas fa-truck"></i> Miễn phí giao hàng từ 2 triệu</div>
            </div>
        </div>
    </div>

    {{-- THÔNG SỐ KỸ THUẬT (Specifications) --}}
    @php
        $specifications = $product->specifications;
        if (is_string($specifications)) {
            $specifications = json_decode($specifications, true);
        }
    @endphp
    @if(is_array($specifications) && count($specifications) > 0)
    <div class="detail-specs">
        <h2>Thông số kỹ thuật</h2>
        <div class="specs-table">
            @foreach($specifications as $key => $val)
            <div class="spec-row">
                <span class="spec-key">{{ $key }}</span>
                <span class="spec-val">{{ $val }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- SẢN PHẨM LIÊN QUAN --}}
    @if($related->count() > 0)
    <div class="related-section">
        <div class="section-header">
            <h2 class="section-title">Sản phẩm <em>liên quan</em></h2>
        </div>
        <div class="products-grid">
            @foreach($related as $rel)
            <div class="product-card">
                <div class="product-image-wrapper">
                    <a href="{{ route('products.show', $rel->slug) }}">
                        <img src="{{ asset('images/' . $rel->image) }}"
                             alt="{{ $rel->name }}"
                             class="product-image">
                    </a>
                    @if($rel->stock == 0)
                        <div class="product-badge badge-out">Hết hàng</div>
                    @endif
                </div>
                <div class="product-info">
                    <p class="product-brand">{{ $rel->brand }}</p>
                    <h3 class="product-name">
                        <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="price-current">{{ number_format($rel->price, 0, ',', '.') }}đ</span>
                        @if($rel->original_price > 0)
                            <span class="price-old">{{ number_format($rel->original_price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                    @if($rel->stock > 0)
                    <form action="{{ route('cart.add', $rel->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-cart">
                            <i class="fas fa-shopping-bag"></i> Thêm vào giỏ
                        </button>
                    </form>
                    @else
                    <button class="btn-add-cart btn-out-stock" disabled>Hết hàng</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function changeQty(delta) {
    var input = document.getElementById('qtyInput');
    var max   = parseInt(input.max) || 99;
    var val   = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}
</script>
@endpush