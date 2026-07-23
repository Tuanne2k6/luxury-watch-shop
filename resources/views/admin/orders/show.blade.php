@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div style="max-width:800px">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
        <div>
            <h2 style="font-size:18px;color:#1a1a2e">Đơn hàng: <span style="color:#c4a96a">{{ $order->order_code }}</span></h2>
            <p class="text-muted" style="font-size:12px;margin-top:4px">Đặt lúc {{ $order->created_at->format('H:i d/m/Y') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

        {{-- THÔNG TIN KHÁCH --}}
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-user" style="color:#c4a96a;margin-right:6px"></i> Khách hàng</h3></div>
            <div class="card-body" style="padding:16px">
                <table style="width:100%;font-size:13.5px">
                    <tr><td style="color:#888;width:110px;padding:6px 0">Họ tên:</td><td><strong>{{ $order->customer_name }}</strong></td></tr>
                    <tr><td style="color:#888;padding:6px 0">Email:</td><td>{{ $order->customer_email }}</td></tr>
                    <tr><td style="color:#888;padding:6px 0">Điện thoại:</td><td>{{ $order->customer_phone }}</td></tr>
                    <tr><td style="color:#888;padding:6px 0;vertical-align:top">Địa chỉ:</td><td>{{ $order->customer_address }}</td></tr>
                    @if($order->note)
                    <tr><td style="color:#888;padding:6px 0;vertical-align:top">Ghi chú:</td><td>{{ $order->note }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- THANH TOÁN & TRẠNG THÁI --}}
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-info-circle" style="color:#c4a96a;margin-right:6px"></i> Thông tin đơn</h3></div>
            <div class="card-body" style="padding:16px">
                <table style="width:100%;font-size:13.5px">
                    <tr>
                        <td style="color:#888;width:110px;padding:6px 0">Trạng thái:</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:6px 0">Tạm tính:</td>
                        <td>{{ number_format($order->total_amount - $order->shipping_fee, 0, ',', '.') }}đ</td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:6px 0">Phí ship:</td>
                        <td>{{ $order->shipping_fee > 0 ? number_format($order->shipping_fee, 0, ',', '.') . 'đ' : 'Miễn phí' }}</td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:6px 0">Tổng cộng:</td>
                        <td><strong style="color:#c4a96a;font-size:16px">{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td>
                    </tr>
                </table>

                {{-- CẬP NHẬT TRẠNG THÁI --}}
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="margin-top:16px;display:flex;gap:8px">
                    @csrf
                    <select name="status" class="form-control" style="flex:1">
                        @foreach(['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy'] as $val => $label)
                            <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-gold btn-sm">
                        <i class="fas fa-check"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SẢN PHẨM TRONG ĐƠN --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list" style="color:#c4a96a;margin-right:6px"></i> Sản phẩm ({{ $order->items->count() }})</h3>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-right">Đơn giá</th>
                        <th class="text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                        <td class="text-right"><strong>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#f8f9fa">
                        <td colspan="3" class="text-right" style="padding:12px 16px;font-weight:600">Tổng cộng:</td>
                        <td class="text-right" style="padding:12px 16px;font-weight:700;color:#c4a96a;font-size:15px">
                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
