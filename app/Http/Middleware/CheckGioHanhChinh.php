<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGioHanhChinh
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $gioHienTai = now()->format('H:i');
        $gioBatDau = '08:30';
        $gioKetThuc = '17:30';

        $ngoaiGio = ($gioHienTai < $gioBatDau || $gioHienTai > $gioKetThuc);

        if ($ngoaiGio) {
            // Nếu là Admin trong môi trường local thì cho phép truy cập để kiểm thử và quản trị
            if (app()->isLocal() && auth()->check() && auth()->user()->isAdmin()) {
                if (!session()->has('warning')) {
                    session()->flash('warning', "⚠️ Lưu ý: Hệ thống đang ngoài giờ hành chính (08:30 - 17:30, hiện tại: $gioHienTai). Bạn đang thao tác với quyền Quản trị viên.");
                }
                return $next($request);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Chức năng chỉ hoạt động trong giờ hành chính từ 08:30 đến 17:30.',
                    'current_time' => $gioHienTai
                ], 403);
            }

            return redirect()->route('sinhvien.index')
                ->with('error', "Chức năng Quản lý lớp học chỉ mở trong giờ hành chính ($gioBatDau - $gioKetThuc). Hiện tại là $gioHienTai.");
        }

        return $next($request);
    }
}
