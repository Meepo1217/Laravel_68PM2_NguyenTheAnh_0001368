@extends('layouts.layoutmaster')
@section('title', 'Quản lý Lớp học')

@push('styles')
<style>
    .filter-card {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
    }
    .table-container {
        background: #ffffff;
        border: 1px solid var(--c-border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .table thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid var(--c-border);
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        padding: 12px 14px;
    }
    .table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 14px;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    .action-btns {
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }
    .sort-link {
        color: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .sort-link:hover {
        color: var(--c-accent2);
    }
    .pagination {
        margin: 0;
        gap: 4px;
    }
    .page-item .page-link {
        color: #1e293b;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 500;
        transition: all .15s ease;
    }
    .page-item.active .page-link {
        background-color: var(--c-accent);
        border-color: var(--c-accent);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.25);
    }
    .page-item .page-link:hover {
        background-color: #f1f5f9;
        color: var(--c-accent2);
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Danh Sách Lớp Học</h2>
        <p class="text-muted small mb-0">Quản lý các lớp học và sĩ số sinh viên trong khoa</p>
    </div>

    @if(Auth::check() && Auth::user()->isAdmin())
        <a href="{{ route('lophoc.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <span>+</span> Thêm Lớp Học Mới
        </a>
    @endif
</div>

{{-- Bộ lọc --}}
<div class="filter-card">
    <form action="{{ route('lophoc.index') }}" method="GET">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">

        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="keyword" class="form-label small fw-semibold">Từ khóa</label>
                <input type="text" id="keyword" name="keyword" class="form-control"
                       placeholder="Tên lớp, mã lớp, giáo viên..." value="{{ $filters['keyword'] ?? '' }}">
            </div>

            <div class="col-md-2">
                <label for="trang_thai" class="form-label small fw-semibold">Trạng thái</label>
                <select id="trang_thai" name="trang_thai" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="1" @selected(($filters['trang_thai'] ?? '') === '1')>Hoạt động</option>
                    <option value="0" @selected(($filters['trang_thai'] ?? '') === '0')>Tạm dừng</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="si_so_min" class="form-label small fw-semibold">Sĩ số từ</label>
                <input type="number" id="si_so_min" name="si_so_min" min="0" class="form-control"
                       placeholder="Từ" value="{{ $filters['si_so_min'] ?? '' }}">
            </div>

            <div class="col-md-2">
                <label for="si_so_max" class="form-label small fw-semibold">Đến</label>
                <input type="number" id="si_so_max" name="si_so_max" min="0" class="form-control"
                       placeholder="Đến" value="{{ $filters['si_so_max'] ?? '' }}">
            </div>

            <div class="col-md-1">
                <label for="perPage" class="form-label small fw-semibold">Dòng/trang</label>
                <select id="perPage" name="perPage" class="form-select" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" title="Lọc kết quả">
                    🔍 Lọc
                </button>
                <a href="{{ route('lophoc.index') }}" class="btn btn-outline-secondary" title="Đặt lại bộ lọc">
                    ↺
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Bảng hiển thị --}}
<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => ($sort === 'id' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            ID {!! $sort === 'id' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ma_lop', 'direction' => ($sort === 'ma_lop' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Mã lớp {!! $sort === 'ma_lop' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ten_lop', 'direction' => ($sort === 'ten_lop' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Tên lớp {!! $sort === 'ten_lop' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'giao_vien', 'direction' => ($sort === 'giao_vien' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Giáo viên CN {!! $sort === 'giao_vien' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>Số điện thoại</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'si_so', 'direction' => ($sort === 'si_so' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Sĩ số {!! $sort === 'si_so' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lopHocs as $lopHoc)
                    <tr>
                        <td class="text-muted fw-semibold">#{{ $lopHoc->id }}</td>
                        <td>
                            <strong class="text-primary font-monospace">{{ $lopHoc->ma_lop }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('lophoc.show', $lopHoc->id) }}" class="fw-semibold text-dark text-decoration-none">
                                {{ $lopHoc->ten_lop }}
                            </a>
                        </td>
                        <td>{{ $lopHoc->giao_vien }}</td>
                        <td class="font-monospace small">{{ $lopHoc->so_dien_thoai_gvcn ?: '-' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $lopHoc->si_so }} SV
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $lopHoc->trang_thai ? 'bg-success' : 'bg-secondary' }}">
                                {{ $lopHoc->trang_thai ? 'Hoạt động' : 'Tạm dừng' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-btns justify-content-end">
                                <a href="{{ route('lophoc.show', $lopHoc->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết lớp">
                                    Chi tiết
                                </a>
                                <a href="{{ route('lophoc.edit', $lopHoc->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa thông tin">
                                    Sửa
                                </a>
                                <form action="{{ route('lophoc.destroy', $lopHoc->id) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp {{ $lopHoc->ten_lop }} ({{ $lopHoc->ma_lop }})?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Không tìm thấy lớp học nào phù hợp với bộ lọc.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    @if($lopHocs->total() > 0)
        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2 bg-light">
            <div class="small text-muted">
                Hiển thị <strong>{{ $lopHocs->firstItem() }}</strong> - <strong>{{ $lopHocs->lastItem() }}</strong> trong tổng số <strong>{{ $lopHocs->total() }}</strong> lớp học
                (Trang <strong>{{ $lopHocs->currentPage() }}</strong> / <strong>{{ $lopHocs->lastPage() }}</strong>)
            </div>
            <div>
                {{ $lopHocs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection
