<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        // Drop units table
        Schema::dropIfExists('units');

        // Update barangs table
        Schema::table('barangs', function (Blueprint $table) {
            // Remove old keadaan_barang enum and stock_barang
            $table->dropColumn(['keadaan_barang', 'stock_barang']);

            // Add keadaan columns (jumlah per kondisi)
            $table->integer('jumlah_baik')->default(0)->after('harga_perolehan');
            $table->integer('jumlah_rusak_ringan')->default(0)->after('jumlah_baik');
            $table->integer('jumlah_rusak_berat')->default(0)->after('jumlah_rusak_ringan');

            // Add lokasi polymorphic (barang langsung di kelas/lab)
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('supplier_id');
            $table->string('lokasi_type')->nullable()->after('lokasi_id');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'lokasi_id', 'lokasi_type']);
            $table->integer('stock_barang')->default(0);
            $table->enum('keadaan_barang', ['baik', 'kurang_baik', 'rusak_berat'])->default('baik');
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('kode_unit')->unique();
            $table->unsignedBigInteger('lokasi_id');
            $table->string('lokasi_type');
            $table->enum('kondisi', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->text('detail_unit')->nullable();
            $table->timestamps();
        });
    }
};
