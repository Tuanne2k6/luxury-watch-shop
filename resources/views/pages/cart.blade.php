{{-- resources/views/pages/cart.blade.php --}}
@extends('layouts.app')
@section('title', 'Giỏ hàng – Luxury Watch')

@section('content')
    @include('partials.alert')

    <div class="page-banner page-banner-sm">
        <div class="container">
            <h1>Giỏ hàng</h1>
            <nav class="breadcrumb-nav">
                <a href="{{ route('home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Giỏ hàng</span>
            </nav>
        </div>
    </div>

    <div class="container cart-layout">
        @if(empty($cart))
            {{-- Giỏ trống --}}
            <div class="empty-state" style="grid-column:1/-1">
                <i class="fas fa-shopping-bag"></i>
                <h3>Giỏ hàng trống</h3>
                <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="{{ route('products.index') }}" class="btn-view-all">Tiếp tục mua sắm</a>
            </div>
        @else
            {{-- ── Danh sách sản phẩm trong giỏ – foreach session cart ── --}}
            <div class="cart-items">
                <div class="cart-header-row">
                    <span>Sản phẩm</span>
                    <span>Đơn giá</span>
                    <span>Số lượng</span>
                    <span>Thành tiền</span>
                    <span></span>
                </div>

                @foreach($cart as $item)
                <div class="cart-row">
                    <div class="cart-product">
                        {{-- asset() lấy ảnh từ tên file đã lưu trong session --}}
                        <img src="{{ asset('images/' . $item['image']) }}"
                             alt="{{ $item['name'] }}"
                        <div class="cart-product-info">
                            <a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a>
                            <small>{{ $item['brand'] }}</small>
                        </div>
                    </div>

                    <div class="cart-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>

                    <div class="cart-qty">
                        <div class="qty-form">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" style="display:contents">
                                @csrf
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}">−</button>
                            </form>
                            <span>{{ $item['quantity'] }}</span>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" style="display:contents">
                                @csrf
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}">+</button>
                            </form>
                        </div>
                    </div>

                    <div class="cart-subtotal">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</div>

                    <div class="cart-remove">
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-remove" title="Xoá">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                <div class="cart-actions">
                    <a href="{{ route('products.index') }}" class="btn-continue">
                        <i class="fas fa-chevron-left"></i> Tiếp tục mua sắm
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-clear-cart"
                                onclick="return confirm('Xoá toàn bộ giỏ hàng?')">
                            <i class="fas fa-trash"></i> Xoá tất cả
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Tổng đơn hàng ── --}}
            <div class="cart-summary">
                <h3>Tổng đơn hàng</h3>
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    @if($total >= 2000000)
                        <span class="text-success">Miễn phí</span>
                    @else
                        <span>30.000đ</span>
                    @endif
                </div>
                <div class="summary-row summary-total">
                    <span>Tổng cộng</span>
                    <span>{{ number_format($total >= 2000000 ? $total : $total + 30000, 0, ',', '.') }}đ</span>
                </div>

                @if($total < 2000000)
                <p class="free-ship-hint">
                    <i class="fas fa-truck"></i>
                    Thêm {{ number_format(2000000 - $total, 0, ',', '.') }}đ để được miễn phí vận chuyển
                </p>
                @endif

                <a href="{{ route('order.checkout') }}" class="btn-checkout">
                    Tiến hành đặt hàng <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
@endsection