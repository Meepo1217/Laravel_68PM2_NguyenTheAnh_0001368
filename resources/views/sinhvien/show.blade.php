@extends('layouts.layoutmaster')
@section('title', 'Hồ sơ Sinh viên: ' . $sinhvien->ho_ten)

@push('styles')
<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        max-width: 850px;
        margin: 0 auto;
    }
    .profile-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 30px 25px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--c-accent), #ef4444);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .profile-body {
        padding: 25px;
    }
    .info-group {
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 0;
    }
    .info-group:last-child {
        border-bottom: none;
    }
    .info-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    .info-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 max-w-850 mx-auto" style="max-width: 850px;">
    <div>
        <h2 class="h4 fw-bold mb-1">Hồ Sơ Chi Tiết Sinh Viên</h2>
        <p class="text-muted small mb-0">Xem thông tin cá nhân và lớp học</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('sinhvien.index') }}" class="btn btn-outline-secondary">
            ← Danh sách
        </a>
        @if(Auth::check() && Auth::user()->isAdmin())
            <a href="{{ route('sinhvien.edit', $sinhvien->id) }}" class="btn btn-warning">
                ✎ Sửa thông tin
            </a>
        @endif
    </div>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(mb_substr($sinhvien->ho_ten, 0, 1, 'UTF-8')) }}
        </div>
        <div>
            <h3 class="h4 fw-bold mb-1">{{ $sinhvien->ho_ten }}</h3>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-light text-dark font-monospace">Mã SV: {{ $sinhvien->ma_sv }}</span>
                <span class="badge {{ $sinhvien->gioi_tinh === 'Nam' ? 'bg-primary' : 'bg-danger' }}">
                    {{ $sinhvien->gioi_tinh }}
                </span>
            </div>
        </div>
    </div>

    <div class="profile-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold text-primary mb-3">Thông Tin Cá Nhân</h5>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $sinhvien->email ?? 'Chưa cập nhật' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Số điện thoại</div>
                    <div class="info-value font-monospace">{{ $sinhvien->so_dien_thoai ?? 'Chưa cập nhật' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Ngày sinh</div>
                    <div class="info-value">{{ $sinhvien->ngay_sinh ? $sinhvien->ngay_sinh->format('d/m/Y') : 'Chưa cập nhật' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Địa chỉ</div>
                    <div class="info-value">{{ $sinhvien->dia_chi ?? 'Chưa cập nhật' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold text-primary mb-3">Thông Tin Lớp Học</h5>
                @if($sinhvien->lopHoc)
                    <div class="info-group">
                        <div class="info-label">Tên lớp</div>
                        <div class="info-value fw-bold text-dark">{{ $sinhvien->lopHoc->ten_lop }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Mã lớp</div>
                        <div class="info-value font-monospace text-primary">{{ $sinhvien->lopHoc->ma_lop }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Giáo viên chủ nhiệm</div>
                        <div class="info-value">{{ $sinhvien->lopHoc->giao_vien }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">SĐT GVCN</div>
                        <div class="info-value font-monospace">{{ $sinhvien->lopHoc->so_dien_thoai_gvcn ?? 'Chưa có' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Sĩ số lớp</div>
                        <div class="info-value">{{ $sinhvien->lopHoc->si_so }} sinh viên</div>
                    </div>
                @else
                    <div class="alert alert-secondary mt-2">
                        Sinh viên này hiện chưa được phân vào lớp học nào.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4 pt-3 border-top text-muted small d-flex justify-content-between">
            <span>Ngày tạo hồ sơ: {{ $sinhvien->created_at->format('d/m/Y H:i') }}</span>
            <span>Cập nhật lần cuối: {{ $sinhvien->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
</div>
@endsection
