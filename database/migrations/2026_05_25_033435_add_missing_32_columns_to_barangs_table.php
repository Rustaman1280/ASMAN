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
            $table->string('reg')->nullable();
            $table->string('alamat')->nullable();
            $table->string('cara_perolehan')->nullable();
            $table->integer('bulan_perolehan')->nullable();
            
            $table->decimal('koreksi', 20, 2)->nullable()->default(0);
            $table->decimal('penyusutan_sd_tahun_sebelumnya', 20, 2)->nullable()->default(0);
            $table->decimal('beban_penyusutan_per_bulan', 20, 2)->nullable()->default(0);
            $table->decimal('bulan_manfaat_sd_des_2024', 20, 2)->nullable()->default(0);
            $table->decimal('akum_peny_sd_des_2024', 20, 2)->nullable()->default(0);
            $table->decimal('koreksi_pembulatan', 20, 2)->nullable()->default(0);
            $table->decimal('masa_manfaat_sd_mar_2025', 20, 2)->nullable()->default(0);
            $table->decimal('beban_penyusutan_2025', 20, 2)->nullable()->default(0);
            $table->decimal('akum_peny_sd_2025', 20, 2)->nullable()->default(0);
            $table->decimal('nilai_buku', 20, 2)->nullable()->default(0);
            
            $table->string('nama_opd')->nullable();
            $table->string('sub_opd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn([
                'reg', 'alamat', 'cara_perolehan', 'bulan_perolehan', 'koreksi', 
                'penyusutan_sd_tahun_sebelumnya', 'beban_penyusutan_per_bulan',
                'bulan_manfaat_sd_des_2024', 'akum_peny_sd_des_2024', 'koreksi_pembulatan',
                'masa_manfaat_sd_mar_2025', 'beban_penyusutan_2025', 'akum_peny_sd_2025',
                'nilai_buku', 'nama_opd', 'sub_opd'
            ]);
        });
    }
};
