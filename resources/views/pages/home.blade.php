{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')
@section('title', 'Luxury Watch – Đồng hồ cao cấp chính hãng')

@section('content')

@include('partials.alert')

{{-- ══════════════════════════════════
     HERO
══════════════════════════════════ --}}
<section class="hero">
    <div class="hero-bg-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-tag">✦ Bộ sưu tập 2026</span>
                <h1 class="hero-title">
                    Đẳng cấp<br><em>thời gian</em>
                </h1>
                <p class="hero-desc">
                    Khám phá bộ sưu tập đồng hồ cao cấp từ các thương hiệu danh tiếng thế giới.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('products.index') }}" class="btn-hero-primary">
                        Khám phá ngay <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('about') }}" class="btn-hero-outline">Về chúng tôi</a>
                </div>
                <div class="hero-stats">
                    <div class="stat"><strong>10K+</strong><span>Khách hàng</span></div>
                    <div class="stat-divider"></div>
                    <div class="stat"><strong>500+</strong><span>Sản phẩm</span></div>
                    <div class="stat-divider"></div>
                    <div class="stat"><strong>50+</strong><span>Thương hiệu</span></div>
                </div>
            </div>
            <div class="hero-image-wrap">
                <div class="hero-image-ring"></div>
                <img src="{{ asset('images/hero-watch.jpg') }}"
                     alt="Luxury Watch" class="hero-img">
                <div class="hero-badge-card">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>Bảo hành 5 năm</strong>
                        <small>Chính hãng toàn quốc</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     FEATURES BAR
══════════════════════════════════ --}}
<section class="features-bar">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                <div>
                    <h4>Miễn phí vận chuyển</h4>
                    <p>Đơn hàng từ 2 triệu đồng</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <h4>Bảo hành 5 năm</h4>
                    <p>Chính hãng toàn quốc</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-award"></i></div>
                <div>
                    <h4>100% chính hãng</h4>
                    <p>Cam kết hàng thật</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-credit-card"></i></div>
                <div>
                    <h4>Trả góp 0% lãi suất</h4>
                    <p>Thanh toán linh hoạt</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     SẢN PHẨM NỔI BẬT
     $featured lấy từ HomeController
══════════════════════════════════ --}}
<section class="section-products">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Nổi bật</span>
            <h2 class="section-title">Sản phẩm <em>được yêu thích</em></h2>
            <p class="section-sub">Những mẫu đồng hồ kết hợp hoàn hảo giữa thiết kế và công nghệ</p>
        </div>

        <div class="products-grid">
            @foreach($featured as $product)
            <div class="product-card">
                <div class="product-image-wrapper">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset('images/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="product-image"
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

                    {{-- Sao đánh giá --}}
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

        <div class="section-footer">
            <a href="{{ route('products.index') }}" class="btn-view-all">
                Xem tất cả sản phẩm <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     BANNER KHUYẾN MÃI
══════════════════════════════════ --}}
<section class="promo-banner">
    <div class="promo-overlay"></div>
    <div class="container">
        <div class="promo-content">
            <div class="promo-text">
                <span class="promo-tag">Ưu đãi có hạn</span>
                <h2>Giảm đến <span class="promo-percent">30%</span></h2>
                <p>Cho các mẫu đồng hồ cao cấp trong tháng này. Số lượng giới hạn!</p>
                <a href="{{ route('products.index') }}" class="btn-promo">
                    Mua ngay <i class="fas fa-fire"></i>
                </a>
            </div>
            <div class="promo-highlights">
                <div class="promo-hl">
                    <i class="fas fa-percentage"></i>
                    <strong>30%</strong>
                    <span>Giảm giá</span>
                </div>
                <div class="promo-hl">
                    <i class="fas fa-shield-alt"></i>
                    <strong>5 năm</strong>
                    <span>Bảo hành</span>
                </div>
                <div class="promo-hl">
                    <i class="fas fa-undo"></i>
                    <strong>30 ngày</strong>
                    <span>Đổi trả</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     DANH MỤC
══════════════════════════════════ --}}
<section class="section-categories">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Danh mục</span>
            <h2 class="section-title">Khám phá <em>theo phong cách</em></h2>
        </div>
        <div class="categories-grid">
            <a href="{{ route('products.index') }}?category=Đồng+hồ+nam" class="cat-card">
                <div class="cat-icon"><i class="fas fa-male"></i></div>
                <h3>Đồng hồ Nam</h3>
                <span>Xem thêm →</span>
            </a>
            <a href="{{ route('products.index') }}?category=Đồng+hồ+nữ" class="cat-card">
                <div class="cat-icon"><i class="fas fa-female"></i></div>
                <h3>Đồng hồ Nữ</h3>
                <span>Xem thêm →</span>
            </a>
            <a href="{{ route('products.index') }}?category=Đồng+hồ+thể+thao" class="cat-card">
                <div class="cat-icon"><i class="fas fa-running"></i></div>
                <h3>Thể Thao</h3>
                <span>Xem thêm →</span>
            </a>
            <a href="{{ route('products.index') }}?category=Đồng+hồ+thông+minh" class="cat-card">
                <div class="cat-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Thông Minh</h3>
                <span>Xem thêm →</span>
            </a>
            <a href="{{ route('products.index') }}?category=Đồng+hồ+cao+cấp" class="cat-card cat-card-wide">
                <div class="cat-icon"><i class="fas fa-gem"></i></div>
                <h3>Cao Cấp</h3>
                <span>Xem thêm →</span>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     TẠI SAO CHỌN CHÚNG TÔI
══════════════════════════════════ --}}
<section class="section-why">
    <div class="container">
        <div class="why-grid">
            <div class="why-text">
                <span class="section-tag">Cam kết của chúng tôi</span>
                <h2 class="section-title">Tại sao chọn<br><em>Luxury Watch?</em></h2>
                <div class="why-items">
                    <div class="why-item">
                        <div class="why-num">01</div>
                        <div>
                            <h4>Hàng chính hãng 100%</h4>
                            <p>Tất cả sản phẩm đều có tem chính hãng, giấy bảo hành đầy đủ từ nhà sản xuất.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-num">02</div>
                        <div>
                            <h4>Đội ngũ tư vấn chuyên nghiệp</h4>
                            <p>Các chuyên gia đồng hồ sẵn sàng hỗ trợ bạn chọn mẫu phù hợp nhất.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-num">03</div>
                        <div>
                            <h4>Bảo hành & bảo dưỡng tận nơi</h4>
                            <p>Dịch vụ bảo hành 5 năm và bảo dưỡng định kỳ miễn phí tại chuỗi cửa hàng.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn-hero-outline" style="display:inline-flex;margin-top:2rem;">
                    Tìm hiểu thêm <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="why-image">
                <img src="{{ asset('images/why-us.jpg') }}"
                     alt="Luxury Watch Store">
                <div class="why-badge">
                    <strong>10+ Năm</strong>
                    <span>Kinh nghiệm</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     ĐÁNH GIÁ KHÁCH HÀNG
══════════════════════════════════ --}}
<section class="section-reviews">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Đánh giá</span>
            <h2 class="section-title">Khách hàng <em>nói gì?</em></h2>
        </div>
        <div class="reviews-grid">
            <div class="review-card">
                <div class="review-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="review-text">"Chất lượng vượt trội, giao hàng nhanh. Chiếc Elegance Gold Edition làm quà tặng được đánh giá rất cao!"</p>
                <div class="review-author">
                    <div class="review-avatar">N</div>
                    <div>
                        <strong>Nguyễn Minh Tuấn</strong>
                        <small>Giám đốc kinh doanh</small>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="review-text">"Dịch vụ tư vấn rất nhiệt tình, nhân viên hiểu sản phẩm sâu. Đồng hồ đúng hàng chính hãng. Hài lòng 100%."</p>
                <div class="review-author">
                    <div class="review-avatar">T</div>
                    <div>
                        <strong>Trần Thị Lan Anh</strong>
                        <small>Kế toán trưởng</small>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="far fa-star"></i>
                </div>
                <p class="review-text">"Mua SmartWatch Elite, pin bền hơn mong đợi. Giao diện app mượt mà. Sản phẩm rất tuyệt vời!"</p>
                <div class="review-author">
                    <div class="review-avatar">L</div>
                    <div>
                        <strong>Lê Quang Hải</strong>
                        <small>Kỹ sư phần mềm</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection