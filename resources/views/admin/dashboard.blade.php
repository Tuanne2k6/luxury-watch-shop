@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-box"></i></div>
        <div>
            <h3>{{ $stats['products'] }}</h3>
            <p>Sản phẩm đang bán</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-shopping-cart"></i></div>
        <div>
            <h3>{{ $stats['orders'] }}</h3>
            <p>Tổng đơn hàng</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-clock"></i></div>
        <div>
            <h3>{{ $stats['orders_pending'] }}</h3>
            <p>Chờ xác nhận</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-coins"></i></div>
        <div>
            <h3>{{ number_format($stats['revenue'], 0, ',', '.') }}đ</h3>
            <p>Doanh thu đã giao</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div>
            <h3>{{ $stats['users'] }}</h3>
            <p>Tài khoản thành viên</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-envelope"></i></div>
        <div>
            <h3>{{ $stats['contacts'] }}</h3>
            <p>Tin nhắn chưa đọc</p>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    {{-- ĐƠN HÀNG GẦN ĐÂY --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-shopping-cart" style="color:#c4a96a;margin-right:6px"></i> Đơn hàng gần đây</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">Xem tất cả</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               style="color:#c4a96a;text-decoration:none;font-weight:500;font-size:12px">
                                {{ $order->order_code }}
                            </a>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted" style="padding:20px">Chưa có đơn hàng nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOP SẢN PHẨM --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-fire" style="color:#c4a96a;margin-right:6px"></i> Sản phẩm bán chạy</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">Xem tất cả</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th class="text-center">Đã bán</th>
                        <th class="text-right">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $i => $p)
                    <tr>
                        <td style="color:#c4a96a;font-weight:700">{{ $i+1 }}</td>
                        <td style="font-size:13px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p->product_name }}</td>
                        <td class="text-center"><strong>{{ $p->total_qty }}</strong></td>
                        <td class="text-right" style="font-size:12px">{{ number_format($p->total_revenue, 0, ',', '.') }}đ</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted" style="padding:20px">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- QUICK ACTIONS --}}
<div style="margin-top:20px;display:flex;gap:12px;flex-wrap:wrap">
    <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i> Thêm sản phẩm mới
    </a>
    <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-warning">
        <i class="fas fa-clock"></i> Xem đơn chờ xác nhận
    </a>
    <a href="{{ route('admin.contacts.index') }}?is_read=0" class="btn btn-info">
        <i class="fas fa-envelope"></i> Tin nhắn chưa đọc
    </a>
</div>

@endsection
