{{-- resources/views/partials/product-card.blade.php --}}
{{-- Dùng: @include('partials.product-card', ['product' => $product]) --}}
<div class="product-card">
    <div class="product-image-wrapper">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ asset('images/products/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 class="product-image"
                 onerror="this.src='{{ asset('images/products/default.jpg') }}'">
        </a>
 
        @if($product->discount_percent > 0)
            <div class="product-badge badge-sale">-{{ $product->discount_percent }}%</div>
        @elseif(!$product->in_stock)
            <div class="product-badge badge-out">Hết hàng</div>
        @endif
 
        <div class="product-overlay-actions">
            <a href="{{ route('products.show', $product->slug) }}" class="overlay-btn" title="Xem chi tiết">
                <i class="fas fa-eye"></i>
            </a>
            @if($product->in_stock)
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="overlay-btn" title="Thêm vào giỏ">
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
 
        {{-- Sao đánh giá --}}
        <div class="product-rating">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($product->rating))
                    <i class="fas fa-star"></i>
                @elseif($i - $product->rating < 1)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
            <span class="rating-count">({{ $product->rating_count }})</span>
        </div>
 
        <div class="product-price">
            <span class="price-current">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @if($product->original_price)
                <span class="price-old">{{ number_format($product->original_price, 0, ',', '.') }}đ</span>
            @endif
        </div>
 
        @if($product->in_stock)
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
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