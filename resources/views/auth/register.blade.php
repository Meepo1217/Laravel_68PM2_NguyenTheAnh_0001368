@extends('layouts.layoutmaster')
@section('title', 'Đăng ký tài khoản')

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
        max-width: 480px;
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
            <h3>Đăng Ký Tài Khoản</h3>
            <p>Tham gia hệ thống Quản lý Sinh viên HUCE</p>
        </div>

        <div class="auth-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required autofocus placeholder="Nguyễn Văn A">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Địa chỉ Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required placeholder="email@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Vai trò đăng ký</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="sinhvien" @selected(old('role') === 'sinhvien')>Sinh viên</option>
                        <option value="admin" @selected(old('role') === 'admin')>Quản trị viên (Admin)</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted small">Mặc định quyền là Sinh viên.</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               required placeholder="Ít nhất 6 ký tự">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" 
                               required placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm mt-2">
                    Tạo Tài Khoản
                </button>
            </form>
        </div>

        <div class="auth-footer border-top">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Đăng nhập</a>
        </div>
    </div>
</div>
@endsection
