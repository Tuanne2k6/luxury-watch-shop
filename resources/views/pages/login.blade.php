{{-- resources/views/pages/login.blade.php --}}
@extends('layouts.app')
@section('title', 'Đăng nhập – Luxury Watch')

@section('content')

<div class="page-banner page-banner-sm">
    <div class="container">
        <h1>Đăng nhập</h1>
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <span>Đăng nhập</span>
        </nav>
    </div>
</div>

<div class="container auth-container">
    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-sign-in-alt"></i>
        </div>
        <h2>Đăng nhập tài khoản</h2>

        {{-- Hiện lỗi --}}
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('auth.login.post') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Nhập email của bạn"
                       class="form-input">
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password"
                       placeholder="Nhập mật khẩu"
                       class="form-input">
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-check-row">
                <label class="check-label">
                    <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn-auth-submit">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>

        <div class="auth-footer">
            <p>Chưa có tài khoản?
                <a href="{{ route('auth.register') }}">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>

@endsection