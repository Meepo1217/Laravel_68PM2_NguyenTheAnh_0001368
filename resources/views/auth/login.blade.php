@extends('layouts.layoutmaster')
@section('title', 'Đăng nhập hệ thống')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
    }
    .auth-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
        width: 100%;
        max-width: 440px;
        overflow: hidden;
    }
    .auth-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 30px 25px;
        text-align: center;
    }
    .auth-header h3 {
        font-weight: 700;
        margin-bottom: 6px;
        font-size: 1.5rem;
    }
    .auth-header p {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0;
    }
    .auth-body {
        padding: 30px 25px;
    }
    .auth-footer {
        text-align: center;
        padding: 15px 25px 25px;
        font-size: 0.9rem;
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h3>Đăng Nhập</h3>
            <p>Hệ thống Quản lý Sinh viên HUCE</p>
        </div>

        <div class="auth-body">
            @if(session('error'))
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Địa chỉ Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           required placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted small" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                    Đăng Nhập
                </button>
            </form>
        </div>

        <div class="auth-footer border-top">
            Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Đăng ký ngay</a>
        </div>
    </div>
</div>
@endsection
