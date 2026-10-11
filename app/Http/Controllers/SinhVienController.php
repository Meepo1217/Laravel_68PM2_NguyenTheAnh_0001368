<?php

namespace App\Http\Controllers;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SinhVienController extends Controller
{
    private const SORTABLE = ['id', 'ma_sv', 'ho_ten', 'email', 'ngay_sinh', 'gioi_tinh', 'lop_hoc_id'];
    private const PER_PAGE_OPTIONS = [5, 10, 20, 50];

    /**
     * Hiển thị danh sách sinh viên có tìm kiếm, lọc, phân trang.
     */
    public function index(Request $request)
    {
        $filters = Validator::make($request->query(), [
            'keyword' => 'nullable|string|max:100',
            'lop_hoc_id' => 'nullable|integer',
            'gioi_tinh' => 'nullable|in:Nam,Nữ,Khác',
            'sort' => 'nullable|in:' . implode(',', self::SORTABLE),
            'direction' => 'nullable|in:asc,desc',
            'perPage' => 'nullable|in:' . implode(',', self::PER_PAGE_OPTIONS),
        ])->valid();

        $sort = $filters['sort'] ?? 'id';
        $direction = $filters['direction'] ?? 'asc';
        $perPage = (int) ($filters['perPage'] ?? 5);

        $sinhviens = SinhVien::with('lopHoc')
            ->when(!empty($filters['keyword']), function ($query) use ($filters) {
                $kw = '%' . $filters['keyword'] . '%';
                $query->where(function ($q) use ($kw) {
                    $q->where('ho_ten', 'like', $kw)
                      ->orWhere('ma_sv', 'like', $kw)
                      ->orWhere('email', 'like', $kw)
                      ->orWhere('so_dien_thoai', 'like', $kw);
                });
            })
            ->when(!empty($filters['lop_hoc_id']), function ($query) use ($filters) {
                $query->where('lop_hoc_id', $filters['lop_hoc_id']);
            })
            ->when(!empty($filters['gioi_tinh']), function ($query) use ($filters) {
                $query->where('gioi_tinh', $filters['gioi_tinh']);
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        $lopHocs = LopHoc::orderBy('ten_lop')->get();

        return view('sinhvien.index', [
            'title' => 'Danh sách sinh viên',
            'sinhviens' => $sinhviens,
            'lopHocs' => $lopHocs,
            'filters' => $filters,
            'sort' => $sort,
            'direction' => $direction,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Hiển thị form thêm mới sinh viên.
     */
    public function create()
    {
        $lopHocs = LopHoc::where('trang_thai', true)->orderBy('ten_lop')->get();

        return view('sinhvien.create', [
            'title' => 'Thêm sinh viên mới',
            'lopHocs' => $lopHocs,
        ]);
    }

    /**
     * Lưu sinh viên mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_sv' => ['required', 'string', 'max:20', 'unique:sinh_viens,ma_sv'],
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150', 'unique:sinh_viens,email'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['required', 'in:Nam,Nữ,Khác'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'lop_hoc_id' => ['nullable', 'exists:lop_hocs,id'],
        ], [
            'ma_sv.required' => 'Vui lòng nhập mã sinh viên.',
            'ma_sv.unique' => 'Mã sinh viên này đã tồn tại trong hệ thống.',
            'ho_ten.required' => 'Vui lòng nhập họ và tên.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'lop_hoc_id.exists' => 'Lớp học được chọn không hợp lệ.',
        ]);

        SinhVien::create($validated);

        return redirect()->route('sinhvien.index')
            ->with('success', 'Thêm mới sinh viên ' . $validated['ho_ten'] . ' thành công!');
    }

    /**
     * Xem thông tin chi tiết một sinh viên.
     */
    public function show($id)
    {
        $sinhvien = SinhVien::with('lopHoc')->findOrFail($id);

        return view('sinhvien.show', [
            'title' => 'Chi tiết sinh viên: ' . $sinhvien->ho_ten,
            'sinhvien' => $sinhvien,
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa sinh viên.
     */
    public function edit($id)
    {
        $sinhvien = SinhVien::findOrFail($id);
        $lopHocs = LopHoc::where('trang_thai', true)->orderBy('ten_lop')->get();

        return view('sinhvien.edit', [
            'title' => 'Chỉnh sửa sinh viên: ' . $sinhvien->ho_ten,
            'sinhvien' => $sinhvien,
            'lopHocs' => $lopHocs,
        ]);
    }

    /**
     * Cập nhật thông tin sinh viên.
     */
    public function update(Request $request, $id)
    {
        $sinhvien = SinhVien::findOrFail($id);

        $validated = $request->validate([
            'ma_sv' => ['required', 'string', 'max:20', 'unique:sinh_viens,ma_sv,' . $sinhvien->id],
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150', 'unique:sinh_viens,email,' . $sinhvien->id],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['required', 'in:Nam,Nữ,Khác'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'lop_hoc_id' => ['nullable', 'exists:lop_hocs,id'],
        ], [
            'ma_sv.required' => 'Vui lòng nhập mã sinh viên.',
            'ma_sv.unique' => 'Mã sinh viên này đã tồn tại trong hệ thống.',
            'ho_ten.required' => 'Vui lòng nhập họ và tên.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'lop_hoc_id.exists' => 'Lớp học được chọn không hợp lệ.',
        ]);

        $sinhvien->update($validated);

        return redirect()->route('sinhvien.index')
            ->with('success', 'Cập nhật thông tin sinh viên ' . $sinhvien->ho_ten . ' thành công!');
    }

    /**
     * Xóa sinh viên khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $sinhvien = SinhVien::findOrFail($id);
        $hoTen = $sinhvien->ho_ten;
        $sinhvien->delete();

        return redirect()->route('sinhvien.index')
            ->with('success', 'Đã xóa sinh viên ' . $hoTen . ' thành công!');
    }
}
