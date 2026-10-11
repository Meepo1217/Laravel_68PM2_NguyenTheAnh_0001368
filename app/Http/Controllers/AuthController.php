<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Hiển thị trang đăng nhập.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('sinhvien.index')
                : redirect()->route('student.developing');
        }

        return view('auth.login', [
            'title' => 'Đăng nhập hệ thống'
        ]);
    }

    /**
     * Xử lý đăng nhập.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Phân luồng điều hướng: Admin vào QLSV, Học sinh vào trang Đang phát triển
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('sinhvien.index'))
                    ->with('success', 'Đăng nhập thành công! Chào mừng Quản trị viên ' . Auth::user()->name);
            }

            return redirect()->route('student.developing')
                ->with('success', 'Đăng nhập thành công! Chào mừng bạn đến với hệ thống.');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Hiển thị trang đăng ký.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('sinhvien.index')
                : redirect()->route('student.developing');
        }

        return view('auth.register', [
            'title' => 'Đăng ký tài khoản'
        ]);
    }

    /**
     * Xử lý đăng ký tài khoản mới.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['nullable', 'in:sinhvien,admin'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'sinhvien',
        ]);

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('sinhvien.index')
                ->with('success', 'Đăng ký tài khoản thành công! Bạn đã được tự động đăng nhập.');
        }

        return redirect()->route('student.developing')
            ->with('success', 'Đăng ký tài khoản thành công! Bạn đã được tự động đăng nhập.');
    }

    /**
     * Trang dành cho học sinh: Đang phát triển.
     */
    public function developing()
    {
        return view('student.developing', [
            'title' => 'Đang phát triển'
        ]);
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Đăng xuất tài khoản thành công.');
    }
}
