@extends('layouts.layoutmaster')
@section('title', 'Quản lý Sinh viên')

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
    .badge-class {
        background: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
    }
    .badge-gender-nam {
        background: #ede9fe;
        color: #6d28d9;
    }
    .badge-gender-nu {
        background: #fce7f3;
        color: #be185d;
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
        border-color: #cbd5e1;
    }
    .page-item.disabled .page-link {
        color: #94a3b8;
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Danh Sách Sinh Viên</h2>
        <p class="text-muted small mb-0">Hệ thống quản lý thông tin sinh viên và phân quyền chức năng</p>
    </div>

    @if(Auth::check() && Auth::user()->isAdmin())
        <a href="{{ route('sinhvien.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <span>+</span> Thêm Sinh Viên Mới
        </a>
    @else
        <div class="badge bg-secondary text-white py-2 px-3">
            🔒 Quyền Sinh viên (Chỉ xem)
        </div>
    @endif
</div>

{{-- Bộ lọc và Tìm kiếm --}}
<div class="filter-card">
    <form action="{{ route('sinhvien.index') }}" method="GET">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $direction }}">

        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="keyword" class="form-label small fw-semibold">Tìm kiếm</label>
                <input type="text" name="keyword" id="keyword" class="form-control"
                       placeholder="Họ tên, mã SV, email, SĐT..." value="{{ $filters['keyword'] ?? '' }}">
            </div>

            <div class="col-md-3">
                <label for="lop_hoc_id" class="form-label small fw-semibold">Lớp học</label>
                <select name="lop_hoc_id" id="lop_hoc_id" class="form-select">
                    <option value="">-- Tất cả các lớp --</option>
                    @foreach($lopHocs as $lop)
                        <option value="{{ $lop->id }}" @selected(($filters['lop_hoc_id'] ?? '') == $lop->id)>
                            {{ $lop->ten_lop }} ({{ $lop->ma_lop }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="gioi_tinh" class="form-label small fw-semibold">Giới tính</label>
                <select name="gioi_tinh" id="gioi_tinh" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Nam" @selected(($filters['gioi_tinh'] ?? '') === 'Nam')>Nam</option>
                    <option value="Nữ" @selected(($filters['gioi_tinh'] ?? '') === 'Nữ')>Nữ</option>
                    <option value="Khác" @selected(($filters['gioi_tinh'] ?? '') === 'Khác')>Khác</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="perPage" class="form-label small fw-semibold">Hiển thị / trang</label>
                <select name="perPage" id="perPage" class="form-select" onchange="this.form.submit()">
                    <option value="5" @selected(($perPage ?? 5) == 5)>5 SV / trang</option>
                    <option value="10" @selected(($perPage ?? 5) == 10)>10 SV / trang</option>
                    <option value="20" @selected(($perPage ?? 5) == 20)>20 SV / trang</option>
                    <option value="50" @selected(($perPage ?? 5) == 50)>50 SV / trang</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" title="Lọc kết quả">
                    🔍 Lọc
                </button>
                <a href="{{ route('sinhvien.index') }}" class="btn btn-outline-secondary" title="Đặt lại bộ lọc">
                    ↺
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Bảng hiển thị Sinh viên --}}
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
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ma_sv', 'direction' => ($sort === 'ma_sv' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Mã SV {!! $sort === 'ma_sv' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ho_ten', 'direction' => ($sort === 'ho_ten' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                            Họ và Tên {!! $sort === 'ho_ten' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                        </a>
                    </th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Lớp học</th>
                    <th>Liên hệ</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sinhviens as $sv)
                    <tr>
                        <td class="text-muted fw-semibold">#{{ $sv->id }}</td>
                        <td>
                            <strong class="text-primary font-monospace">{{ $sv->ma_sv }}</strong>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $sv->ho_ten }}</div>
                            <small class="text-muted">{{ $sv->email ?? 'Chưa có email' }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $sv->gioi_tinh === 'Nam' ? 'badge-gender-nam' : 'badge-gender-nu' }} px-2 py-1">
                                {{ $sv->gioi_tinh }}
                            </span>
                        </td>
                        <td>
                            {{ $sv->ngay_sinh ? $sv->ngay_sinh->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($sv->lopHoc)
                                <span class="badge-class">
                                    {{ $sv->lopHoc->ten_lop }} ({{ $sv->lopHoc->ma_lop }})
                                </span>
                            @else
                                <span class="text-muted small">Chưa xếp lớp</span>
                            @endif
                        </td>
                        <td>
                            <span class="small font-monospace">{{ $sv->so_dien_thoai ?? '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="action-btns justify-content-end">
                                {{-- Nút Xem chi tiết (Ai cũng xem được) --}}
                                <a href="{{ route('sinhvien.show', $sv->id) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                    Chi tiết
                                </a>

                                {{-- Nút Sửa & Xóa (Chỉ hiển thị cho Admin) --}}
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <a href="{{ route('sinhvien.edit', $sv->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa thông tin">
                                        Sửa
                                    </a>

                                    <form action="{{ route('sinhvien.destroy', $sv->id) }}" method="POST" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên {{ $sv->ho_ten }} (Mã: {{ $sv->ma_sv }})?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            Xóa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <div>Không tìm thấy sinh viên nào phù hợp với bộ lọc.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    @if($sinhviens->total() > 0)
        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2 bg-light">
            <div class="small text-muted">
                Hiển thị <strong>{{ $sinhviens->firstItem() }}</strong> - <strong>{{ $sinhviens->lastItem() }}</strong> trong tổng số <strong>{{ $sinhviens->total() }}</strong> sinh viên
                (Trang <strong>{{ $sinhviens->currentPage() }}</strong> / <strong>{{ $sinhviens->lastPage() }}</strong>)
            </div>
            <div>
                {{ $sinhviens->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection