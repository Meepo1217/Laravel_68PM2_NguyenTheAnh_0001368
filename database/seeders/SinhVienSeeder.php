<?php

namespace Database\Seeders;

use App\Models\LopHoc;
use App\Models\SinhVien;
use Illuminate\Database\Seeder;

class SinhVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lopHocs = LopHoc::all();
        $lopIds = $lopHocs->pluck('id')->toArray();
        if (empty($lopIds)) {
            $lopIds = [null];
        }

        $sinhViens = [
            [
                'ma_sv' => 'SV2026001',
                'ho_ten' => 'Nguyễn Thế Anh',
                'email' => 'theanh.nguyen@example.com',
                'so_dien_thoai' => '0987654321',
                'ngay_sinh' => '2004-05-15',
                'gioi_tinh' => 'Nam',
                'dia_chi' => '55 Giải Phóng, Hai Bà Trưng, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026002',
                'ho_ten' => 'Trần Thị Thu Thảo',
                'email' => 'thao.tran@example.com',
                'so_dien_thoai' => '0912345678',
                'ngay_sinh' => '2004-08-20',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Cầu Giấy, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026003',
                'ho_ten' => 'Lê Hoàng Minh',
                'email' => 'minh.le@example.com',
                'so_dien_thoai' => '0933221100',
                'ngay_sinh' => '2003-12-10',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Thanh Xuân, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026004',
                'ho_ten' => 'Phạm Quỳnh Nga',
                'email' => 'nga.pham@example.com',
                'so_dien_thoai' => '0966778899',
                'ngay_sinh' => '2004-03-25',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Đống Đa, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026005',
                'ho_ten' => 'Vũ Tuấn Kiệt',
                'email' => 'kiet.vu@example.com',
                'so_dien_thoai' => '0944556677',
                'ngay_sinh' => '2003-11-02',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Hà Đông, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026006',
                'ho_ten' => 'Đỗ Minh Quân',
                'email' => 'quan.do@example.com',
                'so_dien_thoai' => '0911223344',
                'ngay_sinh' => '2004-01-14',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Ba Đình, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026007',
                'ho_ten' => 'Bùi Phương Linh',
                'email' => 'linh.bui@example.com',
                'so_dien_thoai' => '0922334455',
                'ngay_sinh' => '2004-06-18',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Hoàng Mai, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026008',
                'ho_ten' => 'Hoàng Đức Trọng',
                'email' => 'trong.hoang@example.com',
                'so_dien_thoai' => '0933445566',
                'ngay_sinh' => '2003-09-09',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Tây Hồ, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026009',
                'ho_ten' => 'Ngô Bảo Ngọc',
                'email' => 'ngoc.ngo@example.com',
                'so_dien_thoai' => '0944556677',
                'ngay_sinh' => '2004-10-30',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Long Biên, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026010',
                'ho_ten' => 'Đinh Gia Huy',
                'email' => 'huy.dinh@example.com',
                'so_dien_thoai' => '0955667788',
                'ngay_sinh' => '2004-02-22',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Bắc Từ Liêm, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026011',
                'ho_ten' => 'Lý Khánh Huyền',
                'email' => 'huyen.ly@example.com',
                'so_dien_thoai' => '0966778811',
                'ngay_sinh' => '2004-07-07',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Nam Từ Liêm, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026012',
                'ho_ten' => 'Trịnh Quốc Bảo',
                'email' => 'bao.trinh@example.com',
                'so_dien_thoai' => '0977889922',
                'ngay_sinh' => '2003-04-12',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Thường Tín, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026013',
                'ho_ten' => 'Mai Ánh Tuyết',
                'email' => 'tuyet.mai@example.com',
                'so_dien_thoai' => '0988990033',
                'ngay_sinh' => '2004-12-05',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Đan Phượng, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026014',
                'ho_ten' => 'Dương Văn Long',
                'email' => 'long.duong@example.com',
                'so_dien_thoai' => '0999001144',
                'ngay_sinh' => '2003-08-19',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Hoài Đức, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026015',
                'ho_ten' => 'Phan Yến Nhi',
                'email' => 'nhi.phan@example.com',
                'so_dien_thoai' => '0901122334',
                'ngay_sinh' => '2004-09-15',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Gia Lâm, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026016',
                'ho_ten' => 'Hà Tiến Đạt',
                'email' => 'dat.ha@example.com',
                'so_dien_thoai' => '0912233445',
                'ngay_sinh' => '2004-03-03',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Chương Mỹ, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026017',
                'ho_ten' => 'Chu Mỹ Duyên',
                'email' => 'duyen.chu@example.com',
                'so_dien_thoai' => '0923344556',
                'ngay_sinh' => '2004-11-28',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Sơn Tây, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
            [
                'ma_sv' => 'SV2026018',
                'ho_ten' => 'Võ Hữu Thắng',
                'email' => 'thang.vo@example.com',
                'so_dien_thoai' => '0934455667',
                'ngay_sinh' => '2003-05-21',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Phúc Thọ, Hà Nội',
                'lop_hoc_id' => $lopIds[1] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026019',
                'ho_ten' => 'Đặng Thảo Vy',
                'email' => 'vy.dang@example.com',
                'so_dien_thoai' => '0945566778',
                'ngay_sinh' => '2004-04-10',
                'gioi_tinh' => 'Nữ',
                'dia_chi' => 'Thạch Thất, Hà Nội',
                'lop_hoc_id' => $lopIds[2] ?? $lopIds[0],
            ],
            [
                'ma_sv' => 'SV2026020',
                'ho_ten' => 'Lâm Hùng Dũng',
                'email' => 'dung.lam@example.com',
                'so_dien_thoai' => '0956677889',
                'ngay_sinh' => '2003-10-01',
                'gioi_tinh' => 'Nam',
                'dia_chi' => 'Quốc Oai, Hà Nội',
                'lop_hoc_id' => $lopIds[0] ?? null,
            ],
        ];

        foreach ($sinhViens as $sv) {
            SinhVien::updateOrCreate(['ma_sv' => $sv['ma_sv']], $sv);
        }
    }
}
