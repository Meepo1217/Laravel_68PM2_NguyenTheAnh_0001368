@extends('layouts.layoutmaster')
@section('title', 'Đang phát triển')

@push('styles')
<style>
    .developing-container {
        min-height: calc(100vh - 230px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }
    .developing-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        max-width: 620px;
        width: 100%;
        padding: 48px 36px;
        text-align: center;
    }
    .dev-icon-wrapper {
        width: 88px;
        height: 88px;
        margin: 0 auto 24px;
        background: #fef3c7;
        color: #d97706;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);
    }
    .dev-title {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }
    .dev-desc {
        color: #64748b;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 28px;
    }
    .student-badge-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        text-align: left;
        margin-bottom: 28px;
    }
    .student-badge-box .row-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 14px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .student-badge-box .row-item:last-child {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<div class="developing-container">
    <div class="developing-card">
        <div class="dev-icon-wrapper">
            🚧
        </div>

        <h1 class="dev-title">Đang phát triển</h1>

        <p class="dev-desc">
            Chào mừng <strong>{{ Auth::user()->name }}</strong>!<br>
            Cổng thông tin tra cứu dành riêng cho học sinh đang trong quá trình phát triển.<br>
            Các tính năng xem điểm, thời khóa biểu và kết quả học tập sẽ sớm được ra mắt.
        </p>

        <div class="student-badge-box">
            <div class="row-item">
                <span class="text-muted">Họ và tên:</span>
                <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
            </div>
            <div class="row-item">
                <span class="text-muted">Email:</span>
                <span class="font-monospace text-primary">{{ Auth::user()->email }}</span>
            </div>
            <div class="row-item">
                <span class="text-muted">Vai trò:</span>
                <span class="badge bg-success text-white">Học sinh / Sinh viên</span>
            </div>
            <div class="row-item">
                <span class="text-muted">Trạng thái hệ thống:</span>
                <span class="text-warning fw-semibold">● Đang nâng cấp</span>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger px-4 py-2 fw-semibold">
                    Đăng Xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
