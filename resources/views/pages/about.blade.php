{{-- resources/views/pages/about.blade.php --}}
@extends('layouts.app')
@section('title', 'Giới thiệu – Luxury Watch')

@section('content')
    <div class="page-banner">
        <div class="container">
            <h1>Giới thiệu</h1>
            <nav class="breadcrumb-nav">
                <a href="{{ route('home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Giới thiệu</span>
            </nav>
        </div>
    </div>

    {{-- Câu chuyện thương hiệu --}}
    <section class="about-hero">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="{{ asset('images/about-store.jpg') }}"
                         alt="Luxury Watch Store">
                    <div class="about-badge">
                        <strong>Thành lập 2014</strong>
                        <span>10+ năm kinh nghiệm</span>
                    </div>
                </div>
                <div class="about-text">
                    <span class="section-tag">Câu chuyện của chúng tôi</span>
                    <h2 class="section-title">Hành trình <em>10 năm</em><br>vì đam mê đồng hồ</h2>
                    <p>Luxury Watch ra đời năm 2014 với sứ mệnh mang những chiếc đồng hồ cao cấp chính hãng đến tay người tiêu dùng Việt Nam với mức giá hợp lý và dịch vụ tuyệt vời nhất.</p>
                    <p>Khởi đầu từ một cửa hàng nhỏ trên đường Nguyễn Huệ, chúng tôi đã phát triển thành chuỗi hệ thống với hơn 10.000 khách hàng trung thành và 500+ mẫu đồng hồ từ 50+ thương hiệu danh tiếng.</p>
                    <div class="about-stats">
                        <div class="about-stat">
                            <strong>10K+</strong>
                            <span>Khách hàng tin tưởng</span>
                        </div>
                        <div class="about-stat">
                            <strong>500+</strong>
                            <span>Mẫu sản phẩm</span>
                        </div>
                        <div class="about-stat">
                            <strong>50+</strong>
                            <span>Thương hiệu đối tác</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sứ mệnh & Tầm nhìn --}}
    <section class="mission-section">
        <div class="container">
            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Sứ mệnh</h3>
                    <p>Mang đến những chiếc đồng hồ cao cấp chính hãng với trải nghiệm mua sắm đẳng cấp và dịch vụ hậu mãi tận tâm.</p>
                </div>
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-eye"></i></div>
                    <h3>Tầm nhìn</h3>
                    <p>Trở thành điểm đến đồng hồ cao cấp số 1 Việt Nam, được tin tưởng bởi hàng triệu khách hàng trên cả nước.</p>
                </div>
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-heart"></i></div>
                    <h3>Giá trị cốt lõi</h3>
                    <p>Chân thành, tận tâm, chất lượng. Mỗi sản phẩm và mỗi dịch vụ đều phản ánh cam kết bất biến của chúng tôi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cam kết --}}
    <section class="commitment-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Cam kết</span>
                <h2 class="section-title">Những điều chúng tôi <em>đảm bảo</em></h2>
            </div>
            <div class="commitments-grid">
                @foreach([
                    ['icon'=>'fas fa-certificate','title'=>'Hàng chính hãng 100%','desc'=>'Tất cả sản phẩm đều được nhập khẩu trực tiếp từ các nhà phân phối chính thức, có đầy đủ giấy tờ và tem chính hãng.'],
                    ['icon'=>'fas fa-shield-alt','title'=>'Bảo hành 5 năm','desc'=>'Cam kết bảo hành toàn quốc 5 năm cho tất cả sản phẩm. Sửa chữa miễn phí nếu lỗi do nhà sản xuất.'],
                    ['icon'=>'fas fa-undo','title'=>'Đổi trả 30 ngày','desc'=>'Hoàn tiền 100% hoặc đổi sản phẩm mới trong vòng 30 ngày nếu không hài lòng với bất kỳ lý do gì.'],
                    ['icon'=>'fas fa-headset','title'=>'Hỗ trợ 24/7','desc'=>'Đội ngũ chuyên gia đồng hồ sẵn sàng tư vấn và hỗ trợ bạn mọi lúc qua điện thoại, email hoặc chat trực tuyến.'],
                ] as $c)
                <div class="commitment-card">
                    <div class="commitment-icon"><i class="{{ $c['icon'] }}"></i></div>
                    <h3>{{ $c['title'] }}</h3>
                    <p>{{ $c['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Sẵn sàng khám phá bộ sưu tập?</h2>
                <p>Hơn 500 mẫu đồng hồ cao cấp đang chờ bạn khám phá.</p>
                <div class="cta-buttons">
                    <a href="{{ route('products.index') }}" class="btn-hero-primary">Xem sản phẩm</a>
                    <a href="{{ route('contact.index') }}" class="btn-hero-outline">Liên hệ tư vấn</a>
                </div>
            </div>
        </div>
    </section>
@endsection
