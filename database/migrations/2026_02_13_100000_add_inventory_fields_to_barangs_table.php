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
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('merk_model')->nullable()->after('nama_barang');
            $table->string('no_seri_pabrik')->nullable()->after('merk_model');
            $table->string('ukuran')->nullable()->after('no_seri_pabrik');
            $table->string('bahan')->nullable()->after('ukuran');
            $table->string('tahun_pembuatan')->nullable()->after('bahan');
            $table->decimal('harga_perolehan', 15, 2)->nullable()->after('tahun_pembuatan');
            $table->enum('keadaan_barang', ['baik', 'kurang_baik', 'rusak_berat'])->default('baik')->after('harga_perolehan');
            $table->text('keterangan_mutasi')->nullable()->after('keadaan_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn([
                'merk_model',
                'no_seri_pabrik',
                'ukuran',
                'bahan',
                'tahun_pembuatan',
                'harga_perolehan',
                'keadaan_barang',
                'keterangan_mutasi',
            ]);
        });
    }
};
