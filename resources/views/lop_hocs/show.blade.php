@extends('layouts.layoutmaster')
@section('title', 'Chi tiết lớp học: ' . $lopHoc->ten_lop)

@push('styles')
<style>
    .class-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }
    .info-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .info-value {
        color: #1e293b;
        font-size: 15px;
        font-weight: 500;
    }
    .students-table {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Chi Tiết Lớp Học</h2>
        <p class="text-muted small mb-0">Thông tin lớp học và danh sách sinh viên trực thuộc</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lophoc.index') }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>
        <a href="{{ route('lophoc.edit', $lopHoc->id) }}" class="btn btn-warning">
            ✎ Chỉnh sửa lớp
        </a>
    </div>
</div>

<div class="class-card">
    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
        <div>
            <h3 class="h4 fw-bold text-primary mb-1">{{ $lopHoc->ten_lop }}</h3>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-light text-dark font-monospace border">Mã lớp: {{ $lopHoc->ma_lop }}</span>
                <span class="badge {{ $lopHoc->trang_thai ? 'bg-success' : 'bg-secondary' }}">
                    {{ $lopHoc->trang_thai ? 'Đang hoạt động' : 'Tạm dừng' }}
                </span>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6 px-3 py-2">
                👥 Hiện có: {{ $lopHoc->sinhViens->count() }} / {{ $lopHoc->si_so }} SV
            </span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="info-label">Giáo viên chủ nhiệm</div>
            <div class="info-value fw-semibold text-dark">{{ $lopHoc->giao_vien }}</div>
        </div>
        <div class="col-md-4">
            <div class="info-label">Số điện thoại GVCN</div>
            <div class="info-value font-monospace">{{ $lopHoc->so_dien_thoai_gvcn ?: 'Chưa cập nhật' }}</div>
        </div>
        <div class="col-md-4">
            <div class="info-label">Sĩ số tối đa</div>
            <div class="info-value">{{ $lopHoc->si_so }} sinh viên</div>
        </div>
        <div class="col-12">
            <div class="info-label">Ghi chú</div>
            <div class="info-value text-muted">{{ $lopHoc->ghi_chu ?: 'Không có ghi chú.' }}</div>
        </div>
    </div>
</div>

{{-- Danh sách sinh viên thuộc lớp --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="h5 fw-bold mb-0">
        Danh Sách Sinh Viên Trong Lớp ({{ $lopHoc->sinhViens->count() }})
    </h4>
    <a href="{{ route('sinhvien.create') }}" class="btn btn-sm btn-primary">
        + Thêm sinh viên vào lớp
    </a>
</div>

<div class="students-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px">#</th>
                    <th>Mã SV</th>
                    <th>Họ và Tên</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lopHoc->sinhViens as $index => $sv)
                    <tr>
                        <td class="text-muted small">{{ $index + 1 }}</td>
                        <td>
                            <strong class="text-primary font-monospace">{{ $sv->ma_sv }}</strong>
                        </td>
                        <td class="fw-semibold text-dark">{{ $sv->ho_ten }}</td>
                        <td>
                            <span class="badge {{ $sv->gioi_tinh === 'Nam' ? 'bg-primary' : 'bg-danger' }}">
                                {{ $sv->gioi_tinh }}
                            </span>
                        </td>
                        <td>{{ $sv->ngay_sinh ? $sv->ngay_sinh->format('d/m/Y') : '-' }}</td>
                        <td>{{ $sv->email ?: '-' }}</td>
                        <td class="font-monospace">{{ $sv->so_dien_thoai ?: '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('sinhvien.show', $sv->id) }}" class="btn btn-sm btn-outline-info">
                                Xem hồ sơ
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Chưa có sinh viên nào được phân bổ vào lớp học này.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
