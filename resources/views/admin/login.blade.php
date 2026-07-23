<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Luxury Watch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);min-height:100vh;display:flex;align-items:center;justify-content:center}
        .login-wrap{width:380px}
        .login-brand{text-align:center;margin-bottom:32px}
        .login-brand .icon{width:64px;height:64px;background:rgba(196,169,106,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;color:#c4a96a;margin:0 auto 16px}
        .login-brand h1{color:#fff;font-size:22px;font-weight:700;letter-spacing:2px}
        .login-brand p{color:rgba(255,255,255,.45);font-size:13px;margin-top:4px}
        .login-card{background:rgba(255,255,255,.05);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:36px}
        .alert{padding:11px 14px;border-radius:8px;margin-bottom:20px;font-size:13px;display:flex;align-items:center;gap:8px}
        .alert-success{background:rgba(34,197,94,.15);color:#86efac;border:1px solid rgba(34,197,94,.2)}
        .alert-error{background:rgba(239,68,68,.15);color:#fca5a5;border:1px solid rgba(239,68,68,.2)}
        .form-group{margin-bottom:18px}
        .form-group label{display:block;color:rgba(255,255,255,.65);font-size:13px;margin-bottom:7px}
        .form-group input{width:100%;padding:11px 14px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:9px;color:#fff;font-size:14px;transition:.2s;font-family:inherit}
        .form-group input:focus{outline:none;border-color:#c4a96a;background:rgba(255,255,255,.1)}
        .form-group input::placeholder{color:rgba(255,255,255,.3)}
        .field-error{font-size:12px;color:#fca5a5;margin-top:4px;display:block}
        .btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#c4a96a,#b8943a);color:#fff;font-size:15px;font-weight:600;border:none;border-radius:9px;cursor:pointer;transition:.2s;letter-spacing:.5px;font-family:inherit}
        .btn-login:hover{opacity:.9;transform:translateY(-1px)}
        .back-link{display:block;text-align:center;margin-top:20px;color:rgba(255,255,255,.4);text-decoration:none;font-size:13px;transition:.2s}
        .back-link:hover{color:rgba(255,255,255,.7)}
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-brand">
        <div class="icon">⌚</div>
        <h1>LUXURY WATCH</h1>
        <p>Trang quản trị hệ thống</p>
    </div>
    <div class="login-card">
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

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email quản trị</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Nhập email quản trị"
                       required>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" name="password"
                       placeholder="Nhập mật khẩu"
                       required>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập Admin
            </button>
        </form>
    </div>
    <a href="{{ route('home') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay về trang chủ
    </a>
</div>
</body>
</html>
