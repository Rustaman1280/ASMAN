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
            $table->dropColumn('lokasi_type');
            $table->renameColumn('lokasi_id', 'ruangan_id');
        });

        Schema::table('barangs', function (Blueprint $table) {
            // Nullable just in case some are empty
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['ruangan_id']);
            $table->renameColumn('ruangan_id', 'lokasi_id');
            $table->string('lokasi_type')->nullable();
        });
    }
};
