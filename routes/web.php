<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SinhVienController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chủ điều hướng thông minh theo vai trò
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return Auth::user()->isAdmin()
        ? redirect()->route('sinhvien.index')
        : redirect()->route('student.developing');
});

// ==================== 1. XÁC THỰC: ĐĂNG NHẬP / ĐĂNG KÝ ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==================== 2. CHỨC NĂNG DÀNH CHO HỌC SINH / SINH VIÊN ====================
Route::middleware('auth')->group(function () {
    // Trang hiển thị khi học sinh đăng nhập: tiêu đề "Đang phát triển"
    Route::get('/dang-phat-trien', [AuthController::class, 'developing'])->name('student.developing');
});

// ==================== 3. CHỨC NĂNG DÀNH CHO QUẢN TRỊ VIÊN (ADMIN) ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Toàn bộ CRUD Quản lý Sinh viên
    Route::resource('sinhvien', SinhVienController::class);

    // Quản lý lớp học (kết hợp middleware giờ hành chính)
    Route::resource('lophoc', LopHocController::class)->middleware('check.gio.hanh.chinh');

    // Quản lý menu
    Route::resource('menu', MenuController::class)->except('show');
});
