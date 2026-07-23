<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – @yield('title', 'Luxury Watch')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;color:#333;display:flex;min-height:100vh}

        /* SIDEBAR */
        .sidebar{width:240px;background:#1a1a2e;min-height:100vh;position:fixed;top:0;left:0;z-index:100;display:flex;flex-direction:column}
        .sidebar-brand{padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.08)}
        .sidebar-brand h2{color:#fff;font-size:16px;font-weight:700;letter-spacing:1px}
        .sidebar-brand p{color:#c4a96a;font-size:11px;margin-top:2px}
        .sidebar-nav{flex:1;padding:16px 0;overflow-y:auto}
        .nav-group-title{color:rgba(255,255,255,.35);font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;padding:12px 24px 6px}
        .sidebar-nav a{display:flex;align-items:center;gap:10px;padding:10px 24px;color:rgba(255,255,255,.65);text-decoration:none;font-size:13.5px;transition:.2s;position:relative}
        .sidebar-nav a:hover,.sidebar-nav a.active{color:#fff;background:rgba(255,255,255,.07)}
        .sidebar-nav a.active::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:#c4a96a;border-radius:0 2px 2px 0}
        .sidebar-nav a i{width:18px;text-align:center;font-size:14px}
        .badge-count{margin-left:auto;background:#e74c3c;color:#fff;font-size:10px;padding:2px 7px;border-radius:10px;font-weight:600}
        .sidebar-footer{padding:16px 24px;border-top:1px solid rgba(255,255,255,.08)}
        .sidebar-footer a{color:rgba(255,255,255,.5);text-decoration:none;font-size:13px;display:flex;align-items:center;gap:8px}
        .sidebar-footer a:hover{color:#fff}

        /* MAIN */
        .main-wrap{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{background:#fff;padding:0 28px;height:60px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eee;position:sticky;top:0;z-index:50}
        .topbar h1{font-size:17px;font-weight:600;color:#1a1a2e}
        .topbar-right{display:flex;align-items:center;gap:16px;font-size:13px;color:#666}
        .topbar-right strong{color:#1a1a2e}
        .content{padding:28px;flex:1}

        /* CARDS */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px}
        .stat-card{background:#fff;border-radius:12px;padding:20px;display:flex;align-items:center;gap:16px;box-shadow:0 1px 4px rgba(0,0,0,.06)}
        .stat-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px}
        .stat-icon.gold{background:#fef9ec;color:#c4a96a}
        .stat-icon.blue{background:#eff6ff;color:#3b82f6}
        .stat-icon.green{background:#f0fdf4;color:#22c55e}
        .stat-icon.red{background:#fef2f2;color:#ef4444}
        .stat-icon.purple{background:#f5f3ff;color:#8b5cf6}
        .stat-icon.orange{background:#fff7ed;color:#f97316}
        .stat-card h3{font-size:22px;font-weight:700;color:#1a1a2e}
        .stat-card p{font-size:12px;color:#888;margin-top:2px}

        /* TABLE */
        .card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;margin-bottom:24px}
        .card-header{padding:16px 20px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between}
        .card-header h3{font-size:15px;font-weight:600;color:#1a1a2e}
        .card-body{padding:0}
        table{width:100%;border-collapse:collapse;font-size:13.5px}
        thead th{background:#f8f9fa;padding:11px 16px;text-align:left;font-weight:600;color:#555;font-size:12px;text-transform:uppercase;letter-spacing:.5px;white-space:nowrap}
        tbody td{padding:11px 16px;border-bottom:1px solid #f5f5f5;vertical-align:middle}
        tbody tr:last-child td{border-bottom:none}
        tbody tr:hover{background:#fafafa}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:none;cursor:pointer;transition:.2s;white-space:nowrap}
        .btn-primary{background:#1a1a2e;color:#fff}.btn-primary:hover{background:#2d2d4e}
        .btn-gold{background:#c4a96a;color:#fff}.btn-gold:hover{background:#b8943a}
        .btn-success{background:#22c55e;color:#fff}.btn-success:hover{background:#16a34a}
        .btn-danger{background:#ef4444;color:#fff}.btn-danger:hover{background:#dc2626}
        .btn-warning{background:#f59e0b;color:#fff}.btn-warning:hover{background:#d97706}
        .btn-info{background:#3b82f6;color:#fff}.btn-info:hover{background:#2563eb}
        .btn-outline{background:transparent;border:1px solid #ddd;color:#555}.btn-outline:hover{background:#f5f5f5}
        .btn-sm{padding:5px 12px;font-size:12px}

        /* FORM */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;font-size:13px;font-weight:500;color:#444;margin-bottom:6px}
        .form-control{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:8px;font-size:14px;color:#333;transition:.2s;background:#fff}
        .form-control:focus{outline:none;border-color:#c4a96a;box-shadow:0 0 0 3px rgba(196,169,106,.1)}
        textarea.form-control{resize:vertical;min-height:90px}
        .form-full{grid-column:1/-1}
        .form-check{display:flex;align-items:center;gap:8px;font-size:13px;color:#555}
        .form-check input{width:15px;height:15px;accent-color:#c4a96a}

        /* BADGE STATUS */
        .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-pending{background:#fff3cd;color:#856404}
        .badge-confirmed{background:#d1ecf1;color:#0c5460}
        .badge-shipping{background:#cce5ff;color:#004085}
        .badge-delivered{background:#d4edda;color:#155724}
        .badge-cancelled{background:#f8d7da;color:#721c24}
        .badge-unread{background:#f8d7da;color:#721c24}
        .badge-read{background:#d4edda;color:#155724}
        .badge-active{background:#d4edda;color:#155724}
        .badge-inactive{background:#f8d7da;color:#721c24}

        /* ALERT */
        .alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13.5px;display:flex;align-items:center;gap:10px}
        .alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb}
        .alert-error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}

        /* PAGINATION */
        .pagination{display:flex;gap:4px;justify-content:flex-end;padding:16px 20px}
        .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:13px;text-decoration:none;border:1px solid #eee;color:#555}
        .pagination .active span{background:#1a1a2e;color:#fff;border-color:#1a1a2e}
        .pagination a:hover{background:#f5f5f5}

        /* SEARCH BAR */
        .toolbar{display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap}
        .search-input{padding:9px 14px;border:1px solid #ddd;border-radius:8px;font-size:13.5px;width:280px;color:#333}
        .search-input:focus{outline:none;border-color:#c4a96a}
        select.filter-select{padding:9px 14px;border:1px solid #ddd;border-radius:8px;font-size:13.5px;color:#333;background:#fff}
        select.filter-select:focus{outline:none;border-color:#c4a96a}

        /* PRODUCT IMAGE */
        .product-thumb{width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #eee}
        .text-muted{color:#888;font-size:12px}
        .text-center{text-align:center}
        .text-right{text-align:right}
        .mt-16{margin-top:16px}
        .flex{display:flex;align-items:center;gap:8px}

        /* PRODUCT DETAIL FORM */
        .img-preview{width:100px;height:100px;object-fit:cover;border-radius:10px;border:1px solid #eee;margin-top:8px}
        .toggle-switch{position:relative;display:inline-block;width:40px;height:22px}
        .toggle-switch input{opacity:0;width:0;height:0}
        .toggle-slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#ccc;border-radius:22px;transition:.3s}
        .toggle-slider:before{position:absolute;content:"";height:16px;width:16px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.3s}
        input:checked+.toggle-slider{background:#c4a96a}
        input:checked+.toggle-slider:before{transform:translateX(18px)}

        @media(max-width:768px){
            .sidebar{width:60px}.main-wrap{margin-left:60px}
            .sidebar-brand h2,.sidebar-brand p,.nav-group-title,.sidebar-nav a span,.sidebar-footer a span{display:none}
            .form-grid{grid-template-columns:1fr}
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <h2>⌚ LUXURY WATCH</h2>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group-title">Tổng quan</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>

        <div class="nav-group-title">Quản lý</div>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> <span>Sản phẩm</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> <span>Đơn hàng</span>
            @php $pendingCount = \App\Models\Order::where('status','pending')->count() @endphp
            @if($pendingCount > 0)
                <span class="badge-count">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> <span>Liên hệ</span>
            @php $unread = \App\Models\Contact::where('is_read',false)->count() @endphp
            @if($unread > 0)
                <span class="badge-count">{{ $unread }}</span>
            @endif
        </a>

        <div class="nav-group-title">Hệ thống</div>
        <a href="{{ route('home') }}" target="_blank">
            <i class="fas fa-globe"></i> <span>Xem website</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.5);font-size:13px;display:flex;align-items:center;gap:8px;width:100%">
                <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main-wrap">
    <div class="topbar">
        <h1>@yield('title', 'Dashboard')</h1>
        <div class="topbar-right">
            <i class="fas fa-user-shield" style="color:#c4a96a"></i>
            <span>Xin chào, <strong>{{ session('admin.name', 'Admin') }}</strong></span>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
