{{-- resources/views/pages/order-success.blade.php --}}
@extends('layouts.app')
@section('title', 'Đặt hàng thành công – Luxury Watch')

@section('content')
<div class="container success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Đặt hàng thành công!</h1>
        <p class="success-msg">
            Cảm ơn <strong>{{ $order->customer_name }}</strong> đã tin tưởng Luxury Watch.<br>
            Chúng tôi sẽ liên hệ xác nhận trong vòng <strong>30 phút</strong>.
        </p>

        <div class="order-code-box">
            Mã đơn hàng: <strong>{{ $order->order_code }}</strong>
        </div>

        <div class="order-info-grid">
            @foreach([
                ['label'=>'Email',      'val'=>$order->customer_email],
                ['label'=>'Điện thoại', 'val'=>$order->customer_phone],
                ['label'=>'Địa chỉ',   'val'=>$order->customer_address],
                ['label'=>'Tổng tiền',  'val'=>number_format($order->total_amount, 0, ',', '.') . 'đ'],
            ] as $info)
            <div>
                <span>{{ $info['label'] }}:</span>
                <strong @if($info['label'] === 'Tổng tiền') class="price-main" @endif>
                    {{ $info['val'] }}
                </strong>
            </div>
            @endforeach
        </div>

        <h3 style="margin:2rem 0 1rem">Sản phẩm đã đặt</h3>
        <div class="success-items">
            {{-- foreach order->items lấy từ bảng order_items trong DB --}}
            @foreach($order->items as $item)
            <div class="success-item">
                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</span>
            </div>
            @endforeach
        </div>

        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn-hero-primary">
                <i class="fas fa-home"></i> Về trang chủ
            </a>
            <a href="{{ route('products.index') }}" class="btn-hero-outline">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>
@endsection