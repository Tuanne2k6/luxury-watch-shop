{{-- resources/views/pages/contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Liên hệ – Luxury Watch')

@section('content')
    @include('partials.alert')

    <div class="page-banner">
        <div class="container">
            <h1>Liên hệ</h1>
            <nav class="breadcrumb-nav">
                <a href="{{ route('home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Liên hệ</span>
            </nav>
        </div>
    </div>

    <div class="container contact-layout">
        {{-- Thông tin liên hệ --}}
        <div class="contact-info">
            <h2>Hãy kết nối với chúng tôi</h2>
            <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn một cách nhanh nhất.</p>

            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Địa chỉ cửa hàng</h4>
                        <p>123 Nguyễn Huệ, Quận 1<br>TP. Hồ Chí Minh</p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Hotline hỗ trợ</h4>
                        <p><a href="tel:1900123456">1900 123 456</a><br>
                           <small>Thứ 2 – CN: 9:00 – 21:00</small></p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p><a href="mailto:info@luxurywatch.vn">info@luxurywatch.vn</a><br>
                           <small>Phản hồi trong vòng 24 giờ</small></p>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4>Giờ làm việc</h4>
                        <p>Thứ 2 – Thứ 7: 9:00 – 21:00<br>Chủ nhật: 9:00 – 18:00</p>
                    </div>
                </div>
            </div>

            <div class="contact-social">
                <h4>Theo dõi chúng tôi</h4>
                <div class="social-links" style="justify-content:flex-start">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        {{-- Form liên hệ --}}
        <div class="contact-form-wrap">
            <h2>Gửi tin nhắn cho chúng tôi</h2>

            <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                @csrf

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group">
                        <label>Họ và tên <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Nguyễn Văn A"
                               class="form-input @error('name') input-error @enderror" required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               placeholder="0912 345 678" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="email@example.com"
                           class="form-input @error('email') input-error @enderror" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Chủ đề</label>
                    <select name="subject" class="form-input">
                        <option value="">Chọn chủ đề...</option>
                        <option value="Tư vấn sản phẩm" {{ old('subject') === 'Tư vấn sản phẩm' ? 'selected' : '' }}>Tư vấn sản phẩm</option>
                        <option value="Bảo hành & Sửa chữa" {{ old('subject') === 'Bảo hành & Sửa chữa' ? 'selected' : '' }}>Bảo hành & Sửa chữa</option>
                        <option value="Đổi trả hàng" {{ old('subject') === 'Đổi trả hàng' ? 'selected' : '' }}>Đổi trả hàng</option>
                        <option value="Khiếu nại" {{ old('subject') === 'Khiếu nại' ? 'selected' : '' }}>Khiếu nại</option>
                        <option value="Khác" {{ old('subject') === 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nội dung <span class="required">*</span></label>
                    <textarea name="message" rows="5"
                              placeholder="Nhập nội dung câu hỏi hoặc yêu cầu của bạn..."
                              class="form-input @error('message') input-error @enderror" required>{{ old('message') }}</textarea>
                    @error('message')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-submit-contact">
                    <i class="fas fa-paper-plane"></i> Gửi tin nhắn
                </button>
            </form>
        </div>
    </div>

    {{-- Bản đồ --}}
    <div class="map-section">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4510788939403!2d106.70096311533404!3d10.778188062000783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3a9d8d4e77%3A0x2c95c96d5e87b4b5!2zTmd1eeG7hW4gSHXhu4csIFF14bqtbiAxLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmg!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
@endsection
