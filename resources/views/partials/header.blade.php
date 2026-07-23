{{-- resources/views/partials/header.blade.php --}}
@php
    $cartCount    = array_sum(array_column(session('cart', []), 'quantity'));
    $currentRoute = request()->route()->getName();
@endphp

<header class="header" id="siteHeader">

    {{-- Top Bar --}}
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <a href="tel:1900123456" class="top-bar-link">
                        <i class="fas fa-phone"></i>
                        <span>Hotline: 1900 123 456</span>
                    </a>
                </div>
                <div class="top-bar-right">
                    <span>Miễn phí vận chuyển đơn từ 2.000.000đ</span>
                    <span class="top-bar-highlight">★ Bảo hành 5 năm</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="main-header">
        <div class="container">
            <div class="header-content">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="logo">
                    <div class="logo-icon">⌚</div>
                    <div class="logo-text">
                        <h1>LUXURY WATCH</h1>
                        <p>Đồng hồ cao cấp</p>
                    </div>
                </a>

                {{-- Nav --}}
                <nav class="nav" id="mainNav">
                    <a href="{{ route('home') }}"
                       class="nav-link @if($currentRoute == 'home') active @endif">
                        Trang chủ
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="nav-link @if($currentRoute == 'products.index') active @endif">
                        Sản phẩm
                    </a>
                    <a href="{{ route('about') }}"
                       class="nav-link @if($currentRoute == 'about') active @endif">
                        Giới thiệu
                    </a>
                    <a href="{{ route('contact.index') }}"
                       class="nav-link @if($currentRoute == 'contact.index') active @endif">
                        Liên hệ
                    </a>
                </nav>

                {{-- Actions --}}
                <div class="header-actions">

                    {{-- Tìm kiếm --}}
                    <button class="header-btn" id="searchToggleBtn">
                        <i class="fas fa-search"></i>
                    </button>

                    {{-- Giỏ hàng --}}
                    <a href="{{ route('cart.index') }}" class="header-btn cart-btn">
                        <i class="fas fa-shopping-bag"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge" id="cartBadge">{{ $cartCount }}</span>
                        @else
                            <span class="cart-badge" id="cartBadge" style="display:none">0</span>
                        @endif
                    </a>

                    {{-- Đăng nhập / Tài khoản --}}
                    @if(Auth::check())
                        {{-- Đã đăng nhập: hiện tên + nút đăng xuất --}}
                        <div class="user-menu">
                            <button class="header-btn user-btn" id="userMenuBtn">
                                <i class="fas fa-user-circle"></i>
                                <span class="user-name-short">{{ Auth::user()->name }}</span>
                            </button>
                            <div class="user-dropdown" id="userDropdown">
                                <div class="user-dropdown-header">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <small>{{ Auth::user()->email }}</small>
                                </div>
                                <form action="{{ route('auth.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Chưa đăng nhập: hiện nút đăng nhập / đăng ký --}}
                        <a href="{{ route('auth.login') }}" class="btn-auth-login">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="{{ route('auth.register') }}" class="btn-auth-register">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    @endif

                    {{-- Mobile menu --}}
                    <button class="header-btn mobile-menu-btn" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="search-bar" id="searchBar">
                <form action="{{ route('products.search') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" name="q"
                               placeholder="Tìm kiếm đồng hồ theo tên, thương hiệu..."
                               class="search-input"
                               value="{{ request('q') }}"
                               autocomplete="off">
                        <button type="submit" class="search-submit-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</header>