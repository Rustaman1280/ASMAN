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
        // Remove lokasi and detail from barangs
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['lokasi_id', 'lokasi_type', 'detail_barang']);
        });

        // Add detail_unit to units
        Schema::table('units', function (Blueprint $table) {
            $table->text('detail_unit')->nullable()->after('kondisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_id')->nullable();
            $table->string('lokasi_type')->nullable();
            $table->text('detail_barang')->nullable();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('detail_unit');
        });
    }
};
