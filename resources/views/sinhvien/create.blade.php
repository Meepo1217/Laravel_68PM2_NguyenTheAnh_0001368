@extends('layouts.layoutmaster')
@section('title', 'Thêm mới Sinh viên')

@push('styles')
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        max-width: 800px;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 max-w-800 mx-auto" style="max-width: 800px;">
    <div>
        <h2 class="h4 fw-bold mb-1">Thêm Sinh Viên Mới</h2>
        <p class="text-muted small mb-0">Điền thông tin chi tiết để thêm sinh viên vào hệ thống</p>
    </div>
    <a href="{{ route('sinhvien.index') }}" class="btn btn-outline-secondary">
        ← Quay lại danh sách
    </a>
</div>

<div class="form-card">
    <form action="{{ route('sinhvien.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Mã SV --}}
            <div class="col-md-6 mb-3">
                <label for="ma_sv" class="form-label fw-semibold">Mã Sinh Viên <span class="text-danger">*</span></label>
                <input type="text" name="ma_sv" id="ma_sv" 
                       class="form-control @error('ma_sv') is-invalid @enderror" 
                       value="{{ old('ma_sv') }}" required placeholder="Ví dụ: SV2026001">
                @error('ma_sv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Họ và Tên --}}
            <div class="col-md-6 mb-3">
                <label for="ho_ten" class="form-label fw-semibold">Họ và Tên <span class="text-danger">*</span></label>
                <input type="text" name="ho_ten" id="ho_ten" 
                       class="form-control @error('ho_ten') is-invalid @enderror" 
                       value="{{ old('ho_ten') }}" required placeholder="Ví dụ: Nguyễn Văn A">
                @error('ho_ten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label fw-semibold">Địa chỉ Email</label>
                <input type="email" name="email" id="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="sinhvien@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Số điện thoại --}}
            <div class="col-md-6 mb-3">
                <label for="so_dien_thoai" class="form-label fw-semibold">Số Điện Thoại</label>
                <input type="text" name="so_dien_thoai" id="so_dien_thoai" 
                       class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                       value="{{ old('so_dien_thoai') }}" placeholder="0987xxxxxx">
                @error('so_dien_thoai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- Giới tính --}}
            <div class="col-md-4 mb-3">
                <label for="gioi_tinh" class="form-label fw-semibold">Giới Tính <span class="text-danger">*</span></label>
                <select name="gioi_tinh" id="gioi_tinh" class="form-select @error('gioi_tinh') is-invalid @enderror" required>
                    <option value="Nam" @selected(old('gioi_tinh', 'Nam') === 'Nam')>Nam</option>
                    <option value="Nữ" @selected(old('gioi_tinh') === 'Nữ')>Nữ</option>
                    <option value="Khác" @selected(old('gioi_tinh') === 'Khác')>Khác</option>
                </select>
                @error('gioi_tinh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ngày sinh --}}
            <div class="col-md-4 mb-3">
                <label for="ngay_sinh" class="form-label fw-semibold">Ngày Sinh</label>
                <input type="date" name="ngay_sinh" id="ngay_sinh" 
                       class="form-control @error('ngay_sinh') is-invalid @enderror" 
                       value="{{ old('ngay_sinh') }}">
                @error('ngay_sinh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lớp học --}}
            <div class="col-md-4 mb-3">
                <label for="lop_hoc_id" class="form-label fw-semibold">Lớp Học</label>
                <select name="lop_hoc_id" id="lop_hoc_id" class="form-select @error('lop_hoc_id') is-invalid @enderror">
                    <option value="">-- Chưa xếp lớp --</option>
                    @foreach($lopHocs as $lop)
                        <option value="{{ $lop->id }}" @selected(old('lop_hoc_id') == $lop->id)>
                            {{ $lop->ten_lop }} ({{ $lop->ma_lop }})
                        </option>
                    @endforeach
                </select>
                @error('lop_hoc_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Địa chỉ --}}
        <div class="mb-4">
            <label for="dia_chi" class="form-label fw-semibold">Địa Chỉ Thường Trú</label>
            <input type="text" name="dia_chi" id="dia_chi" 
                   class="form-control @error('dia_chi') is-invalid @enderror" 
                   value="{{ old('dia_chi') }}" placeholder="Số nhà, đường, quận/huyện, tỉnh/thành phố">
            @error('dia_chi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('sinhvien.index') }}" class="btn btn-light border px-4">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                Lưu Sinh Viên
            </button>
        </div>
    </form>
</div>
@endsection
