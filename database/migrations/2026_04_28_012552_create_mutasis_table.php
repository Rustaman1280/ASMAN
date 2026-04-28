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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('unit_barang_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis_mutasi', ['penambahan', 'ubah_status', 'ubah_lokasi', 'peminjaman', 'pengembalian', 'penghapusan']);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_mutasi');
            $table->string('status_awal')->nullable();
            $table->string('status_akhir')->nullable();
            $table->foreignId('ruangan_awal_id')->nullable()->constrained('ruangans')->nullOnDelete();
            $table->foreignId('ruangan_akhir_id')->nullable()->constrained('ruangans')->nullOnDelete();
            $table->string('nama_peminjam')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
