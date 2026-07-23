{{-- resources/views/pages/checkout.blade.php --}}
@extends('layouts.app')
@section('title', 'Đặt hàng – Luxury Watch')

@section('content')

<div class="page-banner page-banner-sm">
    <div class="container">
        <h1>Đặt hàng</h1>
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('cart.index') }}">Giỏ hàng</a>
            <i class="fas fa-chevron-right"></i>
            <span>Đặt hàng</span>
        </nav>
    </div>
</div>

<div class="container checkout-layout">

    {{-- ── FORM THÔNG TIN ── --}}
    <div class="checkout-form-wrap">
        <h2 class="checkout-section-title">
            <i class="fas fa-user"></i> Thông tin giao hàng
        </h2>

        <form action="{{ route('order.place') }}" method="POST" class="checkout-form" id="checkoutForm">
            @csrf

            @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Họ và tên <span class="required">*</span></label>
                    <input type="text" name="customer_name"
                           value="{{ old('customer_name') }}"
                           placeholder="Nguyễn Văn A"
                           class="form-input @error('customer_name') input-error @enderror"
                           required>
                    @error('customer_name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Số điện thoại <span class="required">*</span></label>
                    <input type="tel" name="customer_phone"
                           value="{{ old('customer_phone') }}"
                           placeholder="0912 345 678"
                           class="form-input @error('customer_phone') input-error @enderror"
                           required>
                    @error('customer_phone')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="customer_email"
                       value="{{ old('customer_email') }}"
                       placeholder="email@example.com"
                       class="form-input @error('customer_email') input-error @enderror"
                       required>
                @error('customer_email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Địa chỉ giao hàng <span class="required">*</span></label>
                <textarea name="customer_address" rows="3"
                          placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"
                          class="form-input @error('customer_address') input-error @enderror"
                          required>{{ old('customer_address') }}</textarea>
                @error('customer_address')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="note" rows="2"
                          placeholder="Ghi chú về thời gian, địa điểm giao hàng..."
                          class="form-input">{{ old('note') }}</textarea>
            </div>

            {{-- Lưu payment method vào hidden input --}}
            <input type="hidden" name="payment_method" id="paymentMethodInput" value="cod">

            {{-- ══ PHƯƠNG THỨC THANH TOÁN ══ --}}
            <h2 class="checkout-section-title" style="margin-top:2rem">
                <i class="fas fa-credit-card"></i> Phương thức thanh toán
            </h2>

            <div class="payment-methods">

                {{-- COD --}}
                <label class="payment-option selected" onclick="selectPayment('cod', this)">
                    <input type="radio" name="_payment" value="cod" checked>
                    <i class="fas fa-money-bill-wave" style="color:#27ae60"></i>
                    <div class="payment-label">
                        <span>Thanh toán khi nhận hàng (COD)</span>
                        <small>Trả tiền mặt khi nhận hàng</small>
                    </div>
                </label>

                {{-- Chuyển khoản ngân hàng --}}
                <label class="payment-option" onclick="selectPayment('bank', this)">
                    <input type="radio" name="_payment" value="bank">
                    <i class="fas fa-university" style="color:#2980b9"></i>
                    <div class="payment-label">
                        <span>Chuyển khoản ngân hàng</span>
                        <small>Quét mã QR – xác nhận tức thì</small>
                    </div>
                    <span class="payment-badge">QR</span>
                </label>

                {{-- MoMo --}}
                <label class="payment-option" onclick="selectPayment('momo', this)">
                    <input type="radio" name="_payment" value="momo">
                    <i class="fas fa-mobile-alt" style="color:#ae2d68"></i>
                    <div class="payment-label">
                        <span>Ví MoMo</span>
                        <small>Quét mã QR MoMo – miễn phí</small>
                    </div>
                    <span class="payment-badge" style="background:#ae2d68">QR</span>
                </label>

            </div>

            {{-- Nút Submit --}}
            <button type="button" class="btn-place-order" id="btnOrder" onclick="handleOrder()">
                <i class="fas fa-check-circle"></i> Xác nhận đặt hàng
            </button>
        </form>
    </div>

    {{-- ── TÓM TẮT ĐƠN HÀNG ── --}}
    <div class="order-summary-wrap">
        <h2 class="checkout-section-title">
            <i class="fas fa-shopping-bag"></i> Đơn hàng của bạn
        </h2>

        <div class="order-items-list">
            @foreach($cart as $item)
            <div class="order-item">
                <img src="{{ asset('images/' . $item['image']) }}"
                     alt="{{ $item['name'] }}"
                     onerror="this.src='https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=100'">
                <div class="order-item-info">
                    <p>{{ $item['name'] }}</p>
                    <small>x{{ $item['quantity'] }}</small>
                </div>
                <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
            </div>
            @endforeach
        </div>

        <div class="order-totals">
            <div class="summary-row">
                <span>Tạm tính</span>
                <span>{{ number_format($total, 0, ',', '.') }}đ</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                @if($total >= 2000000)
                    <span class="text-success">Miễn phí</span>
                @else
                    <span>30.000đ</span>
                @endif
            </div>
            <div class="summary-row summary-total">
                <span>Tổng cộng</span>
                <span id="grandTotal">
                    {{ number_format($total >= 2000000 ? $total : $total + 30000, 0, ',', '.') }}đ
                </span>
            </div>
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════════════════════
     MODAL QR THANH TOÁN
════════════════════════════════════════════════════════ --}}
<div id="qrModal" class="qr-modal-overlay" style="display:none">
    <div class="qr-modal">

        {{-- Header --}}
        <div class="qr-modal-header" id="qrModalHeader">
            <i class="fas fa-qrcode"></i>
            <h3 id="qrTitle">Quét mã thanh toán</h3>
            <button class="qr-close-btn" onclick="closeQR()">×</button>
        </div>

        {{-- Số tiền --}}
        <div class="qr-amount">
            <span>Số tiền cần thanh toán:</span>
            <strong id="qrAmount">0đ</strong>
        </div>

        {{-- QR Code image --}}
        <div class="qr-image-wrap">
            <img id="qrImage" src="" alt="QR Code">
            <div class="qr-scan-line"></div>
        </div>

        {{-- Thông tin tài khoản --}}
        <div class="qr-info" id="qrInfo"></div>

        {{-- Hướng dẫn --}}
        <p class="qr-guide" id="qrGuide"></p>

        {{-- Nút xác nhận --}}
        <button class="btn-confirm-paid" id="btnConfirmPaid" onclick="confirmPayment()">
            <i class="fas fa-check-circle"></i> Tôi đã chuyển khoản xong
        </button>

        <p style="font-size:.75rem;color:#999;text-align:center;margin-top:.5rem">
            Đơn hàng sẽ được xác nhận sau khi chúng tôi kiểm tra giao dịch
        </p>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════
     MODAL THANH TOÁN THÀNH CÔNG
════════════════════════════════════════════════════════ --}}
<div id="successModal" class="qr-modal-overlay" style="display:none">
    <div class="qr-modal success-modal">
        <div class="success-anim">
            <div class="success-circle">
                <i class="fas fa-check"></i>
            </div>
        </div>
        <h2>Thanh toán thành công!</h2>
        <p>Cảm ơn bạn đã thanh toán.<br>Đơn hàng của bạn đang được xử lý.</p>
        <div class="success-detail" id="successDetail"></div>
        <button class="btn-confirm-paid" id="btnSubmitOrder"
                style="background:#27ae60"
                onclick="submitOrderForm()">
            <i class="fas fa-check-circle"></i> Hoàn tất đặt hàng
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Dữ liệu cấu hình thanh toán ──────────────────────────────
var BANK_INFO = {
    bankName:   'MBBank',
    accountNo:  '944182006',
    accountName:'LUXURY WATCH CO',
    branch:     'Chi nhánh TP.HCM'
};

var MOMO_INFO = {
    phone:  '0944662723',
    name:   'Truong Duc Tuan',
};

// Lấy tổng tiền từ trang
var totalAmount = document.getElementById('grandTotal').innerText;

// ── Chọn phương thức thanh toán ─────────────────────────────
function selectPayment(method, el) {
    document.querySelectorAll('.payment-option').forEach(function(e) {
        e.classList.remove('selected');
    });
    el.classList.add('selected');
    document.getElementById('paymentMethodInput').value = method;
}

// ── Xử lý khi nhấn "Xác nhận đặt hàng" ─────────────────────
function handleOrder() {
    var method = document.getElementById('paymentMethodInput').value;

    // Kiểm tra form hợp lệ trước
    var form = document.getElementById('checkoutForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    if (method === 'cod') {
        // COD: submit form luôn
        form.submit();
    } else if (method === 'bank') {
        showQR('bank');
    } else if (method === 'momo') {
        showQR('momo');
    }
}

// ── Hiện modal QR ────────────────────────────────────────────
function showQR(method) {
    var modal  = document.getElementById('qrModal');
    var header = document.getElementById('qrModalHeader');
    var title  = document.getElementById('qrTitle');
    var img    = document.getElementById('qrImage');
    var info   = document.getElementById('qrInfo');
    var guide  = document.getElementById('qrGuide');
    var amount = document.getElementById('qrAmount');

    // Số tiền thực từ trang
    var amountNum = totalAmount.replace(/[^0-9]/g, '');

    amount.innerText = totalAmount;

    if (method === 'bank') {
        header.style.background = '#1a5276';
        title.innerText = '🏦 Chuyển khoản ngân hàng';

        // QR VietQR – tạo QR tự động từ API công khai VietQR
        var qrUrl = 'https://img.vietqr.io/image/VCB-' + BANK_INFO.accountNo
                  + '-qr_only.png?amount=' + amountNum
                  + '&addInfo=DH+LUXURYWATCH&accountName=' + encodeURIComponent(BANK_INFO.accountName);
        img.src = qrUrl;

        info.innerHTML =
            '<div class="qr-info-row"><span>Ngân hàng</span><strong>' + BANK_INFO.bankName + '</strong></div>' +
            '<div class="qr-info-row"><span>Số tài khoản</span><strong class="copy-text" onclick="copyText(\'' + BANK_INFO.accountNo + '\')">' + BANK_INFO.accountNo + ' 📋</strong></div>' +
            '<div class="qr-info-row"><span>Chủ tài khoản</span><strong>' + BANK_INFO.accountName + '</strong></div>' +
            '<div class="qr-info-row"><span>Nội dung CK</span><strong class="copy-text" onclick="copyText(\'DH LUXURYWATCH\')">DH LUXURYWATCH 📋</strong></div>';

        guide.innerHTML = '📱 Mở app ngân hàng → Quét mã QR hoặc chuyển khoản theo thông tin trên';

    } else if (method === 'momo') {
        header.style.background = '#a50064';
        title.innerText = '💜 Thanh toán MoMo';

        // QR MoMo – dùng API QR công khai
        var momoQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='
            + encodeURIComponent('2|99|' + MOMO_INFO.phone + '|' + MOMO_INFO.name + '||0|0|' + amountNum + '|DH LUXURYWATCH|transfer_myqr');
        img.src = momoQrUrl;

        info.innerHTML =
            '<div class="qr-info-row"><span>Số điện thoại</span><strong class="copy-text" onclick="copyText(\'' + MOMO_INFO.phone + '\')">' + MOMO_INFO.phone + ' 📋</strong></div>' +
            '<div class="qr-info-row"><span>Tên tài khoản</span><strong>' + MOMO_INFO.name + '</strong></div>' +
            '<div class="qr-info-row"><span>Nội dung</span><strong class="copy-text" onclick="copyText(\'DH LUXURYWATCH\')">DH LUXURYWATCH 📋</strong></div>';

        guide.innerHTML = '📱 Mở app MoMo → Quét mã QR hoặc chuyển tiền theo số điện thoại trên';
    }

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// ── Đóng modal QR ────────────────────────────────────────────
function closeQR() {
    document.getElementById('qrModal').style.display = 'none';
    document.body.style.overflow = '';
}

// ── Xác nhận đã thanh toán → hiện modal thành công ──────────
function confirmPayment() {
    var method = document.getElementById('paymentMethodInput').value;
    var methodLabel = method === 'bank' ? 'Chuyển khoản ngân hàng' : 'Ví MoMo';

    document.getElementById('qrModal').style.display = 'none';

    var detail = document.getElementById('successDetail');
    detail.innerHTML =
        '<div class="qr-info-row"><span>Phương thức</span><strong>' + methodLabel + '</strong></div>' +
        '<div class="qr-info-row"><span>Số tiền</span><strong style="color:#27ae60">' + totalAmount + '</strong></div>' +
        '<div class="qr-info-row"><span>Trạng thái</span><strong style="color:#27ae60">✓ Đã xác nhận</strong></div>';

    document.getElementById('successModal').style.display = 'flex';
}

// ── Submit form sau khi xác nhận thanh toán ──────────────────
function submitOrderForm() {
    document.getElementById('successModal').style.display = 'none';
    document.body.style.overflow = '';
    document.getElementById('checkoutForm').submit();
}

// ── Copy text ────────────────────────────────────────────────
function copyText(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToastCheckout('✓ Đã copy: ' + text);
    });
}

function showToastCheckout(msg) {
    var t = document.createElement('div');
    t.style.cssText = 'position:fixed;bottom:2rem;left:50%;transform:translateX(-50%);background:#333;color:#fff;padding:.7rem 1.5rem;border-radius:8px;font-size:.85rem;z-index:9999;animation:fadeIn .3s';
    t.innerText = msg;
    document.body.appendChild(t);
    setTimeout(function() { t.remove(); }, 2500);
}

// ── Đóng modal khi click overlay ─────────────────────────────
document.getElementById('qrModal').addEventListener('click', function(e) {
    if (e.target === this) closeQR();
});
</script>
@endpush