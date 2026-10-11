<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        // 2. Nếu không truyền role cụ thể, chỉ cần đăng nhập là được qua
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Kiểm tra xem role của user có nằm trong danh sách được phép không
        if (!in_array($user->role, $roles)) {
            // Nếu người dùng không đủ quyền
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Bạn không có quyền thực hiện chức năng này.',
                ], 403);
            }

            $redirectRoute = $user->isAdmin() ? 'sinhvien.index' : 'student.developing';

            return redirect()->route($redirectRoute)
                ->with('error', 'Bạn không có quyền truy cập chức năng này (yêu cầu quyền: ' . implode(', ', $roles) . ')!');
        }

        return $next($request);
    }
}
