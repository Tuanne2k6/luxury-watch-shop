{{-- resources/views/partials/footer.blade.php --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            {{-- Thông tin cửa hàng --}}
            <div class="footer-col">
                <div class="footer-logo">
                    <div class="logo-icon">⌚</div>
                    <div class="logo-text">
                        <h3>LUXURY WATCH</h3>
                        <p>Đồng hồ cao cấp</p>
                    </div>
                </div>
                <p class="footer-desc">
                    Chuyên cung cấp đồng hồ cao cấp, chính hãng từ các thương hiệu nổi tiếng thế giới.
                    Chất lượng được cam kết, phong cách được tôn vinh.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            {{-- Liên kết nhanh --}}
            <div class="footer-col">
                <h4 class="footer-heading">Liên kết nhanh</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Trang chủ</a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fas fa-chevron-right"></i> Sản phẩm</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> Giới thiệu</a></li>
                    <li><a href="{{ route('contact.index') }}"><i class="fas fa-chevron-right"></i> Liên hệ</a></li>
                    <li><a href="{{ route('cart.index') }}"><i class="fas fa-chevron-right"></i> Giỏ hàng</a></li>
                </ul>
            </div>

            {{-- Hỗ trợ --}}
            <div class="footer-col">
                <h4 class="footer-heading">Hỗ trợ khách hàng</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Chính sách đổi trả</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Chính sách vận chuyển</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Phương thức thanh toán</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Câu hỏi thường gặp</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Hướng dẫn bảo quản</a></li>
                </ul>
            </div>

            {{-- Liên hệ --}}
            <div class="footer-col">
                <h4 class="footer-heading">Liên hệ</h4>
                <ul class="footer-contact-list">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>123 Nguyễn Huệ, Q.1, TP. Hồ Chí Minh</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:1900123456">1900 123 456</a>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:info@luxurywatch.vn">info@luxurywatch.vn</a>
                    </li>
                </ul>
                <div class="footer-hours">
                    <p><i class="fas fa-clock"></i> <strong>Giờ làm việc:</strong></p>
                    <p>Thứ 2 – Thứ 7: 9:00 – 21:00</p>
                    <p>Chủ nhật: 9:00 – 18:00</p>
                </div>
            </div>
        </div>

        {{-- Newsletter --}}
        <div class="footer-newsletter">
            <div class="newsletter-text">
                <h4>Đăng ký nhận ưu đãi</h4>
                <p>Nhận thông tin sản phẩm mới & khuyến mãi độc quyền</p>
            </div>
            <form class="newsletter-form" id="newsletterForm">
                @csrf
                <input type="email" placeholder="Nhập email của bạn..." required>
                <button type="submit" class="btn-newsletter">Đăng ký</button>
            </form>
        </div>

        {{-- Bottom --}}
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Luxury Watch. Tất cả các quyền được bảo lưu.</p>
            <div class="footer-payments">
                <img src="{{ asset('images/payment-visa.png') }}" alt="Visa" title="Visa">
                <img src="{{ asset('images/payment-mastercard.png') }}" alt="Mastercard" title="Mastercard">
                <img src="{{ asset('images/payment-momo.png') }}" alt="MoMo" title="MoMo">
                <img src="{{ asset('images/payment-vnpay.png') }}" alt="VNPay" title="VNPay">
            </div>
        </div>
    </div>
</footer>
