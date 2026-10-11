@extends('layouts.layoutmaster')
@section('title', 'Thêm lớp học mới')

@push('styles')
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        max-width: 750px;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 mx-auto" style="max-width: 750px;">
    <div>
        <h2 class="h4 fw-bold mb-1">Thêm Lớp Học Mới</h2>
        <p class="text-muted small mb-0">Nhập đầy đủ thông tin để khởi tạo lớp học mới</p>
    </div>
    <a href="{{ route('lophoc.index') }}" class="btn btn-outline-secondary">
        ← Quay lại danh sách
    </a>
</div>

<div class="form-card">
    <form action="{{ route('lophoc.store') }}" method="POST">
        @csrf
        @include('lop_hocs._form')
        
        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="{{ route('lophoc.index') }}" class="btn btn-light border px-4">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">Thêm lớp học</button>
        </div>
    </form>
</div>
@endsection
