<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sv', 20)->unique();
            $table->string('ho_ten', 100);
            $table->string('email', 150)->nullable()->unique();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['Nam', 'Nữ', 'Khác'])->default('Nam');
            $table->string('dia_chi', 255)->nullable();
            $table->foreignId('lop_hoc_id')->nullable()->constrained('lop_hocs')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
