@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')

@section('content')

<div class="toolbar">
    <form method="GET" action="{{ route('admin.orders.index') }}" style="display:contents">
        <input type="text" name="q" class="search-input" placeholder="Mã đơn, tên, email, SĐT..." value="{{ request('q') }}">
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Tất cả ({{ $statusCounts['all'] }})</option>
            <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>Chờ xác nhận ({{ $statusCounts['pending'] }})</option>
            <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>Đã xác nhận ({{ $statusCounts['confirmed'] }})</option>
            <option value="shipping"  {{ request('status')=='shipping'  ? 'selected':'' }}>Đang giao ({{ $statusCounts['shipping'] }})</option>
            <option value="delivered" {{ request('status')=='delivered' ? 'selected':'' }}>Đã giao ({{ $statusCounts['delivered'] }})</option>
            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>Đã hủy ({{ $statusCounts['cancelled'] }})</option>
        </select>
        <button type="submit" class="btn btn-outline"><i class="fas fa-search"></i></button>
        @if(request('q') || request('status'))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline"><i class="fas fa-times"></i></a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3>Danh sách đơn hàng ({{ $orders->total() }})</h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th class="text-right">Tổng tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                           style="color:#c4a96a;font-weight:600;text-decoration:none;font-size:12px">
                            {{ $order->order_code }}
                        </a>
                    </td>
                    <td>
                        <strong style="font-size:13.5px">{{ $order->customer_name }}</strong>
                        <br><small class="text-muted">{{ $order->customer_email }}</small>
                    </td>
                    <td class="text-muted">{{ $order->customer_phone }}</td>
                    <td class="text-right"><strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td>
                    <td class="text-center">
                        <span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span>
                    </td>
                    <td class="text-muted" style="font-size:12px">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="text-center">
                        <div class="flex" style="justify-content:center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                  onsubmit="return confirm('Xóa đơn hàng này?')">
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
                    <td colspan="7" class="text-center text-muted" style="padding:32px">
                        <i class="fas fa-shopping-cart" style="font-size:32px;display:block;margin-bottom:8px;opacity:.3"></i>
                        Không có đơn hàng nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $orders->appends(request()->all())->links() }}

@endsection
