{{-- resources/views/emails/contact.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Liên hệ mới – Luxury Watch</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',Arial,sans-serif; background:#f4f4f4; color:#333; }
        .wrapper { max-width:600px; margin:30px auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 20px rgba(0,0,0,.1); }
        .header { background:#111; padding:28px 40px; text-align:center; }
        .header .logo { font-size:20px; font-weight:700; color:#b8974e; letter-spacing:3px; }
        .header .logo span { color:#fff; }
        .header p { color:rgba(255,255,255,.5); font-size:11px; letter-spacing:2px; margin-top:4px; }
        .badge { background:#b8974e; color:#fff; text-align:center; padding:10px; font-size:13px; letter-spacing:1px; }
        .body { padding:30px 40px; }
        .body h2 { font-size:18px; color:#111; margin-bottom:18px; }
        .body h2 span { color:#b8974e; }
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        table tr { border-bottom:1px solid #f0f0f0; }
        table tr:last-child { border-bottom:none; }
        table td { padding:11px 10px; font-size:14px; }
        table td:first-child { width:140px; font-weight:600; color:#555; background:#fafafa; }
        .msg-box { background:#faf8f3; border-left:4px solid #b8974e; border-radius:4px; padding:18px; margin-bottom:22px; }
        .msg-box p { font-size:14px; line-height:1.8; color:#444; white-space:pre-wrap; }
        .btn { display:block; width:fit-content; margin:0 auto 10px; background:#b8974e; color:#fff !important; padding:11px 28px; border-radius:4px; text-decoration:none; font-size:14px; font-weight:600; }
        .divider { height:1px; background:#eee; margin:18px 0; }
        .footer { background:#f9f9f9; padding:18px 40px; text-align:center; border-top:1px solid #eee; }
        .footer p { font-size:12px; color:#999; line-height:1.8; }
        .footer a { color:#b8974e; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div class="logo">⌚ LUXURY <span>WATCH</span></div>
        <p>ĐỒNG HỒ CAO CẤP</p>
    </div>

    <div class="badge">📬 BẠN CÓ TIN NHẮN LIÊN HỆ MỚI</div>

    <div class="body">
        <h2>Tin nhắn từ <span>{{ $senderName }}</span></h2>

        <table>
            <tr>
                <td>Họ tên</td>
                <td>{{ $senderName }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td><a href="mailto:{{ $senderEmail }}" style="color:#b8974e">{{ $senderEmail }}</a></td>
            </tr>
            <tr>
                <td>Điện thoại</td>
                <td>{{ $senderPhone }}</td>
            </tr>
            <tr>
                <td>Chủ đề</td>
                <td>{{ $senderSubject }}</td>
            </tr>
            <tr>
                <td>Thời gian</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <p style="font-weight:600;margin-bottom:10px;color:#555">📝 Nội dung:</p>
        <div class="msg-box">
            <p>{{ $messageBody }}</p>
        </div>

        <a href="mailto:{{ $senderEmail }}?subject=Re: {{ $senderSubject }}" class="btn">
            ↩ Trả lời ngay
        </a>
    </div>

    <div class="footer">
        <p>
            Email tự động từ <a href="#">luxurywatch.vn</a><br>
            123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh | Hotline: 1900 123 456
        </p>
    </div>

</div>
</body>
</html>
