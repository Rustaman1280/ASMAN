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
            $table->string('jenis')->nullable()->after('bahan');
            $table->string('kategori')->nullable()->after('jenis');
            $table->string('penanggungjawab')->nullable()->after('kategori');
            $table->integer('masa_manfaat_bulan')->nullable()->after('harga_perolehan');
        });

        Schema::table('unit_barangs', function (Blueprint $table) {
            $table->string('no_mesin')->nullable()->after('keterangan');
            $table->string('no_rangka')->nullable()->after('no_mesin');
            $table->string('status')->nullable()->after('kondisi');
            $table->decimal('harga_perolehan', 15, 2)->nullable()->after('status');
            $table->decimal('akumulasi_penyusutan', 15, 2)->nullable()->after('harga_perolehan');
            $table->decimal('nilai_buku', 15, 2)->nullable()->after('akumulasi_penyusutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'kategori', 'penanggungjawab', 'masa_manfaat_bulan']);
        });

        Schema::table('unit_barangs', function (Blueprint $table) {
            $table->dropColumn(['no_mesin', 'no_rangka', 'status', 'harga_perolehan', 'akumulasi_penyusutan', 'nilai_buku']);
        });
    }
};
