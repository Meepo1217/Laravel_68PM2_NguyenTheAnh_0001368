<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LopHocSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            LopHocSeeder::class,
            MenuSeeder::class,
            SinhVienSeeder::class,
        ]);

        // Tạo tài khoản Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Quản trị viên (Admin)',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // Tạo tài khoản Sinh viên
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Nguyễn Thế Anh (Sinh viên)',
                'password' => bcrypt('123456'),
                'role' => 'sinhvien',
            ]
        );
    }
}
