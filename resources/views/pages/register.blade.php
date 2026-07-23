{{-- resources/views/pages/register.blade.php --}}
@extends('layouts.app')
@section('title', 'Đăng ký – Luxury Watch')

@section('content')

<div class="page-banner page-banner-sm">
    <div class="container">
        <h1>Đăng ký</h1>
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <span>Đăng ký</span>
        </nav>
    </div>
</div>

<div class="container auth-container">
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <h2>Tạo tài khoản mới</h2>

        <form action="{{ route('auth.register.post') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       placeholder="Nguyễn Văn A"
                       class="form-input">
                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="email@example.com"
                       class="form-input">
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="tel" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="0912 345 678"
                       class="form-input">
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password"
                       placeholder="Ít nhất 6 ký tự"
                       class="form-input">
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation"
                       placeholder="Nhập lại mật khẩu"
                       class="form-input">
            </div>

            <button type="submit" class="btn-auth-submit">
                <i class="fas fa-user-plus"></i> Đăng ký
            </button>
        </form>

        <div class="auth-footer">
            <p>Đã có tài khoản?
                <a href="{{ route('auth.login') }}">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>

@endsection