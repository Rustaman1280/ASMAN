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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru_jurusan', 'wakil_kepsek', 'kepala_sekolah', 'bendahara'])->default('guru_jurusan')->after('password');
            $table->foreignId('jurusan_id')->nullable()->after('role')->constrained('jurusans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['role', 'jurusan_id']);
        });
    }
};
